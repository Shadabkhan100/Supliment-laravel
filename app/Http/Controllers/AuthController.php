<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Mail\WelcomeUserMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Services\SupabaseStorageService;
use App\Models\CartModel;
use App\Models\ProductsModel;
use App\Models\GuestOrder;
use Illuminate\Support\Facades\DB;
use App\Services\UserEmailService;
use Illuminate\Support\Facades\Mail;
use App\Mail\AuthAttemptEmail;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
 use Illuminate\Support\Facades\Http;
use App\Models\BundleOrder;
use App\Models\EmailCampaign;
  use App\Models\PromoCode;
use Illuminate\Support\Str;
use App\Services\OneSignalService;





class AuthController extends Controller
{
    


public function sendTestEmail(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'type' => 'nullable|string',
    ]);

    $user = User::first();

    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'No user found.',
        ], 404);
    }

    EmailCampaign::create([
        'user_id' => $user->id,
        'email_type' => 'sequence_1',
        'send_at' => now()->addMinute(),
        'is_sent' => false,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Email scheduled successfully.',
    ]);
}


public function registerUser(Request $request)
{
    try {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'phone' => 'nullable|string',
            'country' => 'nullable|string',
            'address' => 'nullable|string',
            'dob' => 'nullable|date',
            'status' => 'nullable|string',
        ]);

        DB::beginTransaction();

        $guestId = trim($request->cookie('guest_id', ''));

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone'    => $validated['phone'] ?? null,
            'country'  => $validated['country'] ?? null,
            'address'  => $validated['address'] ?? null,
            'dob'      => $validated['dob'] ?? null,
            'status'   => $validated['status'] ?? 'user',
        ]);

        // Login
        
        if (in_array($user->status, [null, 'User'])) {
    Auth::login($user);
    $request->session()->regenerate();
}

        // =========================
        // MIGRATE GUEST DATA
        // =========================
        if (!empty($guestId)) {

            CartModel::where('guest_id', $guestId)
                ->update([
                    'user_id'  => $user->id,
                    'guest_id' => null,
                ]);

            GuestOrder::where('guest_id', $guestId)
                ->update([
                    'user_id'  => $user->id,
                    'guest_id' => null,
                ]);


              BundleOrder::where('guest_id', $guestId)
                ->update([
                  'user_id'  => $user->id,
                  'guest_id' => null,
              ]);
        }

        DB::commit();
      

try {

    $promo = PromoCode::create([
        'user_id'    => $user->id,
        'code'       => 'WELCOME-' . strtoupper(Str::random(8)),
        'discount'   => 10,
        'expires_at' => now()->addHours(24),
    ]);

$emails = [
    [
        'email_type' => 'sequence_1',
        'send_at' => now(), // Immediately after account creation
        'promo_code' => $promo->code,
    ],
    [
        'email_type' => 'sequence_2',
        'send_at' => now()->addDay(), // After 24 hours
    ],
    [
        'email_type' => 'sequence_3',
        'send_at' => now()->addDays(2), // After 2 days
    ],
    [
        'email_type' => 'sequence_4',
        'send_at' => now()->addDays(3), // After 3 days
    ],
    [
        'email_type' => 'sequence_5',
        'send_at' => now()->addDays(5), // After 5 days
    ],
];

    foreach ($emails as $email) {
        EmailCampaign::create([
            'user_id'    => $user->id,
            'email_type' => $email['email_type'],
            'send_at'    => $email['send_at'],
            'promo_code' => $email['promo_code'] ?? null,
        ]);
    }

app(OneSignalService::class)->sendToAdmins(
    '👤 New User Registered',
    "A new user, \"{$user->name}\", has successfully registered on the website."
);


        return response()
            ->json([
                'success' => true,
                'message' => 'Account created successfully.',
                'redirect' => '/profile'
            ])
            ->withoutCookie('guest_id');
} catch (\Exception $e) {

    DB::rollBack();

    return response()->json([
        'success' => false,
        'message' => 'Failed to create welcome email sequence.',
        'error' => $e->getMessage(),
        'line' => $e->getLine(),
        'file' => basename($e->getFile()),
    ], 500);
}


    } catch (ValidationException $e) {

        return response()->json([
            'success' => false,
            'message' => 'Validation failed.',
            'errors' => $e->errors()
        ], 422);

    } catch (\Exception $e) {

        DB::rollBack();

        Log::error('Registration Error', [
            'message' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile(),
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Registration failed.',
            'error' => $e->getMessage()
        ], 500);
    }
}








public function LoginUser(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    if (Auth::attempt([
        'email' => $request->email,
        'password' => $request->password
    ])) {

        $request->session()->regenerate();

        return response()->json([
            'success' => true,
            'message' => 'User logged in successfully.',
            'redirect' => '/profile'
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'Invalid email or password.'
    ], 401);
}
public function loginAdmin(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    if (Auth::attempt([
        'email' => $request->email,
        'password' => $request->password
    ])) {

        $request->session()->regenerate();

        return redirect('/admin')
       ->with('success', 'User logged out successfully.');

    }

    return response()->json([
        'success' => false,
        'message' => 'Invalid email or password.'
    ], 401);
}




   public function logoutUser(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/')
    ->with('success', 'User logged out successfully.');
}


public function deleteUser(Request $request)
{
    $user = Auth::user();

    Auth::logout();

    if ($user) {
        $user->delete();
    }

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/')
        ->with('success', 'Your account has been deleted successfully.');

}
   public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (auth()->attempt($credentials)) {

        if (auth()->user()->status !== 'admin') {
            auth()->logout();
            return back()->with('error', 'Unauthorized access');
        }

        return redirect()->route('admin.dashboard');
    }

    return back()->with('error', 'Invalid credentials');
}




    public function updateProfile(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'country' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'dob' => 'nullable|date',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = [];

        if ($request->has('name')) {
            $data['name'] = $request->name;
        }

        if ($request->has('phone')) {
            $data['phone'] = $request->phone;
        }

        if ($request->has('country')) {
            $data['country'] = $request->country;
        }

        if ($request->has('address')) {
            $data['address'] = $request->address;
        }

        if ($request->has('dob')) {
            $data['dob'] = $request->dob;
        }

if ($request->hasFile('avatar')) {

    $data['avatar'] = SupabaseStorageService::upload(
        $request->file('avatar'),
        'users/profile'
    );
}

        $user->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully',
            'user' => $user->fresh()
        ]);
    }







     public function resetPasswordView(){

       return view("pages.reset_password_form");

     }




     public function sendResetOtp(Request $request)
{
    try {

        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        /*
        |--------------------------------------------------------------------------
        | Don't reveal whether the email exists
        |--------------------------------------------------------------------------
        */

        if (!$user) {

            return response()->json([
                'success' => false,
                'message' => 'We could not find an account with that email address.'
            ], 404);
        }

        /*
        |--------------------------------------------------------------------------
        | Generate 6 digit OTP
        |--------------------------------------------------------------------------
        */

        $otp = (string) random_int(100000, 999999);

        /*
        |--------------------------------------------------------------------------
        | Store OTP
        |--------------------------------------------------------------------------
        */

        $user->password_reset_otp = $otp;

        $user->password_reset_otp_expires_at = now()->addMinutes(10);

        $user->save();

        /*
        |--------------------------------------------------------------------------
        | Send OTP through your existing email service
        |--------------------------------------------------------------------------
        */

        $emailService = app(UserEmailService::class);

        $emailService->sendUserEmail(
            $user,
            'password_reset_otp',
            [
                'otp' => $otp
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'A verification code has been sent to your email.'
        ]);

    } catch (ValidationException $e) {

        return response()->json([
            'success' => false,
            'message' => 'Please enter a valid email address.',
            'errors' => $e->errors()
        ], 422);

    } catch (\Throwable $e) {

        Log::error('Password Reset OTP Error', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Unable to send the verification code.',
            'error' => $e->getMessage()
        ], 500);
    }
}





           public function verifyResetOtp(Request $request)
{
    try {

        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {

            return response()->json([
                'success' => false,
                'message' => 'Invalid verification request.'
            ], 404);
        }

        /*
        |--------------------------------------------------------------------------
        | Check OTP
        |--------------------------------------------------------------------------
        */

        if (
            !$user->password_reset_otp ||
            $user->password_reset_otp !== $request->otp
        ) {

            return response()->json([
                'success' => false,
                'message' => 'Invalid verification code.'
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | Check expiration
        |--------------------------------------------------------------------------
        */

        if (
            !$user->password_reset_otp_expires_at ||
            now()->greaterThan($user->password_reset_otp_expires_at)
        ) {

            return response()->json([
                'success' => false,
                'message' => 'This verification code has expired. Please request a new code.'
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | Mark OTP as verified
        |--------------------------------------------------------------------------
        |
        | We use the session temporarily so the user can proceed
        | to the password step.
        |
        */

        session([
            'password_reset_user_id' => $user->id,
            'password_reset_verified' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'OTP verified successfully.'
        ]);

    } catch (ValidationException $e) {

        return response()->json([
            'success' => false,
            'message' => 'Invalid OTP.',
            'errors' => $e->errors()
        ], 422);

    } catch (\Throwable $e) {

        Log::error('Password Reset OTP Verification Error', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Unable to verify the code.'
        ], 500);
    }
}





   public function updateResetPassword(Request $request)
{
    try {

        $request->validate([
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Check OTP verification
        |--------------------------------------------------------------------------
        */

        if (
            !session('password_reset_verified') ||
            !session('password_reset_user_id')
        ) {

            return response()->json([
                'success' => false,
                'message' => 'Please verify your email first.'
            ], 403);
        }

        $user = User::find(session('password_reset_user_id'));

        if (!$user) {

            session()->forget([
                'password_reset_user_id',
                'password_reset_verified'
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Invalid password reset request.'
            ], 404);
        }

        /*
        |--------------------------------------------------------------------------
        | Update password
        |--------------------------------------------------------------------------
        */

        $user->password = Hash::make($request->password);

        /*
        |--------------------------------------------------------------------------
        | Clear OTP
        |--------------------------------------------------------------------------
        */

        $user->password_reset_otp = null;
        $user->password_reset_otp_expires_at = null;

        $user->save();

        /*
        |--------------------------------------------------------------------------
        | Clear reset session
        |--------------------------------------------------------------------------
        */

        session()->forget([
            'password_reset_user_id',
            'password_reset_verified'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Your password has been updated successfully.',
            'redirect' => '/login'
        ]);

    } catch (ValidationException $e) {

        return response()->json([
            'success' => false,
            'message' => 'Please check your password.',
            'errors' => $e->errors()
        ], 422);

    } catch (\Throwable $e) {

        Log::error('Password Reset Update Error', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Unable to update your password.'
        ], 500);
    }
}
}