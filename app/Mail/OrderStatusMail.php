<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class OrderStatusMail extends Mailable
{
    public $order;
    public $product;

    public function __construct($order, $product)
    {
        $this->order = $order;
        $this->product = $product;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Confirmation #' . $this->order->id,
        );
    }

   public function content(): Content
{
    return new Content(
        view: 'emails.order-status',
        with: [
            'order' => $this->order,
            'product' => $this->product,
        ]
    );
}


}