<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeUserMail;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function registerUser(Request $request)
    {
        // 1. Validate input
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'phone' => 'nullable',
            'country' => 'nullable',
            'address' => 'nullable',
            'dob' => 'nullable|date',
        ]);

        // 2. Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'country' => $request->country,
            'address' => $request->address,
            'dob' => $request->dob,
        ]);

        // 3. Send welcome email
        Mail::to($user->email)->send(new WelcomeUserMail($user));

        // 4. Response
        return response()->json([
            'message' => 'User registered successfully and email sent',
            'user' => $user
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

        return redirect('/')
            ->with('success', 'User logged in successfully.');
    }

    return back()->with('error', 'Invalid email or password.');
}


   public function logoutUser(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/')
    ->with('success', 'User logged out successfully.');
}
}