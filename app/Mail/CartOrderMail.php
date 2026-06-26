<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class CartOrderMail extends Mailable
{
    public $orderedProducts;
    public $total;
    public $customer;

    public function __construct($orderedProducts, $total, $customer)
    {
        $this->orderedProducts = $orderedProducts;
        $this->total = $total;
        $this->customer = $customer;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Confirmation'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.cart-order',
            with: [
                'orderedProducts' => $this->orderedProducts,
                'total' => $this->total,
                'customer' => $this->customer,
            ]
        );
    }
}