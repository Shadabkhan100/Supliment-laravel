<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class OrderStatusMail extends Mailable
{
    public $order;
    public $product;
    public $currentStatus;
    public function __construct($order, $product,$currentStatus)
    {
        $this->order = $order;
        $this->product = $product;
        $this->currentStatus=$currentStatus;
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
            'currentStatus' => $this->currentStatus
        ]
    );
}


}