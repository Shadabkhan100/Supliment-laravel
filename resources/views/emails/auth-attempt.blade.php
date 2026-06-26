<x-mail::message>

<div style="text-align:center; margin-bottom:20px;">
    <img src="https://slimza.com/public/images/logo.png"
         alt="SLIMZA"
         style="max-width:180px;">
</div>

# Security Alert

Hello {{ $user->name }},

We detected a failed sign-in attempt on your SLIMZA account.

To help protect your account, we are notifying you whenever a login attempt does not succeed.

### Attempt Details

**IP Address:** {{ $ipAddress }}

**Location:** {{ $location ?? 'Location unavailable' }}

**Time:** {{ now()->format('d M Y h:i A') }}

<x-mail::panel>
If this was you, no further action is required.

If you do not recognize this activity, we recommend updating your password immediately and reviewing your account security.
</x-mail::panel>

<x-mail::button :url="'https://slimza.com/login'">
Secure My Account
</x-mail::button>

### Why did you receive this email?

SLIMZA continuously monitors account activity and sends security notifications when unusual or unsuccessful login attempts occur. These alerts help keep your account and personal information protected.

If you believe this login attempt was not made by you, please contact our support team as soon as possible.

**Support Email:** info@slimza.com

Thank you for helping us keep your account secure.

Regards,<br>
**SLIMZA Security Team**

<small style="color:#888;">
This is an automated security notification. Please do not reply directly to this email.
</small>

</x-mail::message>
```
