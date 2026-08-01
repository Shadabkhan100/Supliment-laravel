<?php

namespace App\Mail;

use App\Mail\BundleOrderMail;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class BundleOrderMail extends Mailable
{
    public $bundleOrder;

    public function __construct($bundleOrder)
    {
        $this->bundleOrder = $bundleOrder;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bundle Order Confirmation #'.$this->bundleOrder->id,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.bundle-order',
            with: [
                'bundleOrder' => $this->bundleOrder,
            ]
        );
    }
}