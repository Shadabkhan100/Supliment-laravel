<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use App\Models\PromoCode;

class UpsellPromotionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $promoCode;
    public $discount;
    public $expiresAt;
    public $userId;
    public $guestId;
    public $currency;
    public $amountPaid;
    public $amountInGbp;
    public $orderId;
    public $products;

    public function __construct(
        PromoCode $promoCode,
        $discount,
        $expiresAt,
        $userId,
        $guestId,
        $currency,
        $amountPaid,
        $amountInGbp,
        $orderId
    ) {

        /*
        |--------------------------------------------------------------------------
        | PROMO CODE
        |--------------------------------------------------------------------------
        |
        | We are now receiving the actual PromoCode model.
        |
        | Store only the actual promo code string in the Mailable.
        |
        */

        $this->promoCode = (string) $promoCode->code;


        /*
        |--------------------------------------------------------------------------
        | PROMOTION DATA
        |--------------------------------------------------------------------------
        */

        $this->discount = is_numeric($discount)
            ? (float) $discount
            : 0;

        $this->expiresAt   = $expiresAt;
        $this->userId      = $userId;
        $this->guestId     = $guestId;
        $this->currency    = $currency;
        $this->amountPaid  = $amountPaid;
        $this->amountInGbp = $amountInGbp;
        $this->orderId     = $orderId;


        /*
        |--------------------------------------------------------------------------
        | PRODUCTS
        |--------------------------------------------------------------------------
        */

        $this->products = [];


        /*
        |--------------------------------------------------------------------------
        | GET PRODUCTS
        |--------------------------------------------------------------------------
        */

        try {

            $response = Http::timeout(20)
                ->acceptJson()
                ->get(
                    'https://slimza.com/api/get-all-product'
                );


            if ($response->successful()) {

                $data = $response->json();

                $products = $data['data'] ?? [];


                if (is_array($products)) {

                    /*
                    |--------------------------------------------------------------------------
                    | FILTER VALID PRODUCTS
                    |--------------------------------------------------------------------------
                    */

                    $products = array_values(
                        array_filter(
                            $products,
                            function ($product) {

                                return is_array($product)
                                    && !empty($product['id'])
                                    && !empty($product['name'])
                                    && !empty($product['main_image']);

                            }
                        )
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | RANDOMIZE PRODUCTS
                    |--------------------------------------------------------------------------
                    */

                    shuffle($products);


                    /*
                    |--------------------------------------------------------------------------
                    | SELECT MAXIMUM 5 PRODUCTS
                    |--------------------------------------------------------------------------
                    */

                    $this->products = array_slice(
                        $products,
                        0,
                        5
                    );
                }
            }

        } catch (\Throwable $e) {

            /*
            |--------------------------------------------------------------------------
            | DO NOT BREAK EMAIL IF PRODUCT API FAILS
            |--------------------------------------------------------------------------
            */

            $this->products = [];

        }
    }


    /*
    |--------------------------------------------------------------------------
    | BUILD EMAIL
    |--------------------------------------------------------------------------
    */

    public function build()
    {
        return $this
            ->subject(
                '🎁 Your Exclusive ' . $this->discount . '% Slimza Reward'
            )
            ->view(
                'emails.upsell-promotion'
            );
    }
}