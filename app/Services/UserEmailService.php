<?php

namespace App\Services;

use App\Mail\WelcomeUserMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\AuthAttemptEmail;
use App\Mail\BundleOrderMail;
use App\Mail\PromotionMail;
use App\Mail\OrderStatusMail;
use App\Mail\UpsellPromotionMail;


class UserEmailService
{
    public function sendUserEmail($user, string $type = 'register', array $data = [])
    {
        try{
            switch ($type) {

              case 'register':

              Mail::to($user->email)
    ->send(
        new WelcomeUserMail(
            $user,
            $data['sequence'] ?? 1,
            $data['promo_code'] ?? null
        )
    );

                break;

                case 'auth_attempt':
                    Mail::to($user->email)
                        ->send(
                            new AuthAttemptEmail(
                                $user,
                                $data['ip'] ?? 'Unknown'
                            )
                        );
                    break;
                case 'order_status':

    Mail::to($user->email)
        ->send(
            new OrderStatusMail(
                $data['order'],
                $data['product'],
                $data['current_status'] ?? null
            )
        );

    break;

                case 'birthday':
                    // future implementation
                    // Mail::to($user->email)->send(new BirthdayMail($user));
                    break;
                 case 'bundle_order':

    Mail::to($user->email)
        ->send(
            new BundleOrderMail(
                $data['bundle_order']
            )
        );
break;

 case 'promotion':

    Mail::to($user->email)
        ->send(
            new PromotionMail(
                $data['promotion_text'] ?? ''
            )
        );

    break;


case 'upsell_promotion':

    /*
    |--------------------------------------------------------------------------
    | GET PROMO CODE
    |--------------------------------------------------------------------------
    */

    $promoCode = $data['promo_code'] ?? null;

    /*
    |--------------------------------------------------------------------------
    | MAKE SURE PROMO CODE EXISTS
    |--------------------------------------------------------------------------
    */

    if (!$promoCode) {

        throw new \Exception(
            'Upsell promo code was not provided.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | IF STRING ID WAS PASSED, FIND THE RECORD
    |--------------------------------------------------------------------------
    */

    if (is_numeric($promoCode)) {

        $promoCode = \App\Models\PromoCode::find($promoCode);

    }

    /*
    |--------------------------------------------------------------------------
    | IF ARRAY WAS PASSED
    |--------------------------------------------------------------------------
    */

    if (is_array($promoCode)) {

        $promoCode = \App\Models\PromoCode::find(
            $promoCode['id'] ?? null
        );

    }

    /*
    |--------------------------------------------------------------------------
    | VALIDATE PROMO MODEL
    |--------------------------------------------------------------------------
    */

    if (!$promoCode instanceof \App\Models\PromoCode) {

        throw new \Exception(
            'Invalid PromoCode record passed to UpsellPromotionMail.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SEND EMAIL
    |--------------------------------------------------------------------------
    */

    Mail::to($user->email)
        ->send(
            new UpsellPromotionMail(

                $promoCode,

                $data['discount'] ?? $promoCode->discount,

                $data['expires_at'] ?? $promoCode->expires_at,

                $data['user_id'] ?? null,

                $data['guest_id'] ?? null,

                $data['currency'] ?? null,

                $data['amount_paid'] ?? 0,

                $data['amount_in_gbp'] ?? 0,

                $data['order_id'] ?? null

            )
        );

    break;
case 'password_reset_otp':

    Mail::to($user->email)->send(
        new \App\Mail\PasswordResetOtpMail(
            $user,
            $data['otp']
        )
    );

    break;

                default:
                    Log::warning("Unknown email type: {$type}");
                    break;
            }
        } catch (\Throwable $e) {

    throw $e;
}
    }
}