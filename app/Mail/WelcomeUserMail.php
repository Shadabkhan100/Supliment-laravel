<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;

class WelcomeUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $sequence;
    public $promoCode;

    public function __construct($user, $sequence = 1, $promoCode = null)
    {
        $this->user = $user;
        $this->sequence = $sequence;
         $this->promoCode = $promoCode;
    }

    public function build()
    {
        return $this->subject('Welcome to SLIMZA 🚀')
                    ->view('emails.welcome');
    }
}