<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeUserMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Services\SupabaseStorageService;


class AuthController extends Controller
{
    public function registerUser(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
        'phone' => 'nullable',
        'country' => 'nullable',
        'address' => 'nullable',
        'dob' => 'nullable|date',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'phone' => $request->phone,
        'country' => $request->country,
        'address' => $request->address,
        'dob' => $request->dob,
        'status' => 'user'
    ]);

    // OPTIONAL: auto login after registration (IMPORTANT PART)
    Auth::login($user);
    $request->session()->regenerate();

    Mail::to($user->email)->send(new WelcomeUserMail($user));

    return response()->json([
        'success' => true,
        'message' => 'User registered successfully and logged in',
        'redirect' => '/profile'
    ]);
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