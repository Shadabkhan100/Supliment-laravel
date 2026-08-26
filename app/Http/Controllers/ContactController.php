<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactForm;
use App\Services\OneSignalService;


class ContactController extends Controller
{
 
      public function postComment(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'message' => 'required|string',
        'remember' => 'nullable|boolean',
    ]);

    ContactForm::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'message' => $validated['message'],
        'remember' => $request->boolean('remember'),
    ]);
app(OneSignalService::class)->sendToAdmins(
    '📩 New Contact Message',
    "You have received a new message from {$validated['name']} ({$validated['email']})."
);
    return response()->json([
        'success' => true,
        'message' => 'Your message has been sent successfully.',
    ], 200);
}
}
