<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\UserEmailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendWelcomeSequenceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $sequence;

    public function __construct(User $user, int $sequence)
    {
        $this->user = $user;
        $this->sequence = $sequence;
    }

    public function handle(): void
    {
        app(UserEmailService::class)->sendUserEmail(
            $this->user,
            'register',
            [
                'sequence' => $this->sequence,
            ]
        );
    }
}