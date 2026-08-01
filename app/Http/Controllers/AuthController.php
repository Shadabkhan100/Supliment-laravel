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



class AuthController extends Controller
{
    


public function sendTestEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'type'  => 'nullable|string'
        ]);

        // fake user object (no DB required)
        $user = new User();
        $user->email = $request->email;
        $user->name = 'Test User';

        $type = $request->type ?? 'register';

        app(UserEmailService::class)
            ->sendUserEmail($user, $type);

        return response()->json([
            'success' => true,
            'message' => "Test email sent using type: {$type}"
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

            app(UserEmailService::class)
            ->sendUserEmail($user, 'register');

        return response()
            ->json([
                'success' => true,
                'message' => 'Account created successfully.',
                'redirect' => '/profile'
            ])
            ->withoutCookie('guest_id');

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
        'email'     => 'required|email',
        'password'  => 'required',
        'latitude'  => 'nullable',
        'longitude' => 'nullable',
        'location' => 'nullable|string',
         
    ]);

    if (Auth::attempt([
        'email'    => $request->email,
        'password' => $request->password
    ])) {

        $request->session()->regenerate();

        $user = Auth::user();

        $ipAddress = $request->ip();
        $location = 'Unknown';

        // GPS from frontend
      if (
    !empty($request->latitude) &&
    !empty($request->longitude)
) {

    try {

        $response = Http::withHeaders([
            'User-Agent' => 'Slimza/1.0'
        ])->get(
            'https://nominatim.openstreetmap.org/reverse',
            [
                'lat' => $request->latitude,
                'lon' => $request->longitude,
                'format' => 'jsonv2'
            ]
        );

        if ($response->successful()) {

            $geo = $response->json();

            $location = $geo['display_name']
                ?? 'Location unavailable';

        }

    } catch (\Exception $e) {

        $location =
            $request->latitude .
            ', ' .
            $request->longitude;
    }

}

        // Send login notification email
        try {
         $location = $request->location ?? $location;
            Mail::to($user->email)->send(
                new AuthAttemptEmail(
                    $user,
                    $ipAddress,
                    $location
                )
            );

        } catch (\Exception $e) {
            // Optional:
            // Log::error($e->getMessage());
        }

        return response()->json([
            'success'  => true,
            'message'  => 'User logged in successfully.',
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

}