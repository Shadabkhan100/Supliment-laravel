<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class PromotionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $promotionText;
    public $products;

    public function __construct($promotionText)
    {
        $this->promotionText = $promotionText;
        $this->products = [];

        try {

            /*
            |--------------------------------------------------------------------------
            | Get Products From Slimza API
            |--------------------------------------------------------------------------
            */

            $response = Http::timeout(20)
                ->acceptJson()
                ->get('https://slimza.com/api/get-all-product');


            /*
            |--------------------------------------------------------------------------
            | Check API Response
            |--------------------------------------------------------------------------
            */

            if (!$response->successful()) {

                throw new \Exception(
                    'Product API returned HTTP ' . $response->status()
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Decode JSON
            |--------------------------------------------------------------------------
            */

            $data = $response->json();


            /*
            |--------------------------------------------------------------------------
            | Get Product Data
            |--------------------------------------------------------------------------
            */

            if (!isset($data['data']) || !is_array($data['data'])) {

                throw new \Exception(
                    'Invalid product API response. "data" array not found.'
                );
            }


            $products = $data['data'];


            /*
            |--------------------------------------------------------------------------
            | Remove Empty Products
            |--------------------------------------------------------------------------
            */

            $products = array_filter($products, function ($product) {

                return is_array($product) && !empty($product);

            });


            /*
            |--------------------------------------------------------------------------
            | Re-index Array
            |--------------------------------------------------------------------------
            */

            $products = array_values($products);


            /*
            |--------------------------------------------------------------------------
            | Randomize Products
            |--------------------------------------------------------------------------
            */

            shuffle($products);


            /*
            |--------------------------------------------------------------------------
            | Select Maximum 5 Products
            |--------------------------------------------------------------------------
            */

            $this->products = array_slice($products, 0, 5);

        } catch (\Throwable $e) {

            /*
            |--------------------------------------------------------------------------
            | Don't Stop Promotion Email
            |--------------------------------------------------------------------------
            |
            | The promotion email should still be sent even if the
            | product API fails.
            |
            */

            $this->products = [];
        }
    }


    public function build()
    {
        return $this
            ->subject('✨ Special Promotion from Slimza')
            ->view('emails.promotion');
    }
}