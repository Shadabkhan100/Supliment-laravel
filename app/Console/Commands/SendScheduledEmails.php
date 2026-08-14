<?php

namespace App\Console\Commands;

use App\Models\EmailCampaign;
use App\Services\UserEmailService;
use Illuminate\Console\Command;

class SendScheduledEmails extends Command
{
    protected $signature = 'emails:send';

    protected $description = 'Send scheduled emails';

    public function handle()
    {
        $emails = EmailCampaign::where('is_sent', false)
            ->where('send_at', '<=', now())
            ->get();

        foreach ($emails as $email) {

            $sequence = str_replace(
                'sequence_',
                '',
                $email->email_type
            );

            app(UserEmailService::class)
                ->sendUserEmail(
                    $email->user,
                    'register',
                    [
                        'sequence'   => $sequence,
                        'promo_code' => $email->promo_code, // <-- Pass the promo code
                    ]
                );

            $email->update([
                'is_sent' => true,
            ]);
        }
    }
}