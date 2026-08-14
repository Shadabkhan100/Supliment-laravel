<?php

namespace App\Services;

use App\Mail\WelcomeUserMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\AuthAttemptEmail;
use App\Mail\BundleOrderMail;


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
                             $data['product']
                           )
                         );

                break;

                case 'birthday':
                    // future implementation
                    // Mail::to($user->email)->send(new BirthdayMail($user));
                    break;

                case 'promotion':
                    // future implementation
                    break;
                


                 case 'bundle_order':

    Mail::to($user->email)
        ->send(
            new BundleOrderMail(
                $data['bundle_order']
            )
        );
break;
                default:
                    Log::warning("Unknown email type: {$type}");
                    break;
            }
        } catch (\Exception $e) {
            Log::warning("Email sending failed ({$type}): " . $e->getMessage());
        }
    }
}