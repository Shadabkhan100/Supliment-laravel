<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;

class OneSignalService
{
    protected string $url;
    protected string $appId;
    protected string $apiKey;

    public function __construct()
    {
        $this->url = 'https://api.onesignal.com/notifications';
        $this->appId = config('onesignal.app_id');
        $this->apiKey = config('onesignal.api_key');
    }

    /**
     * Send notification to everyone
     */
    public function broadcast(string $title, string $message)
    {
        return $this->send([
            'included_segments' => ['All'],
        ], $title, $message);
    }

    /**
     * Send notification to a specific subscription
     */
    public function sendToSubscription(string $subscriptionId, string $title, string $message)
    {
        return $this->send([
            'include_subscription_ids' => [$subscriptionId],
        ], $title, $message);
    }

    /**
     * Send notification to a specific user
     */
    public function sendToUser(User $user, string $title, string $message)
    {
        if (empty($user->onesignal_subscription_id)) {
            return false;
        }

        return $this->sendToSubscription(
            $user->onesignal_subscription_id,
            $title,
            $message
        );
    }

    /**
     * Send notification to all admins
     */
    public function sendToAdmins(string $title, string $message)
    {
        $admins = User::where('role', 'admin')
            ->whereNotNull('onesignal_subscription_id')
            ->pluck('onesignal_subscription_id')
            ->toArray();

        if (empty($admins)) {
            return false;
        }

        return $this->send([
            'include_subscription_ids' => $admins,
        ], $title, $message);
    }

    /**
     * Core sender
     */
    protected function send(array $target, string $title, string $message)
    {
        return Http::withHeaders([
            'Authorization' => 'Key ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post($this->url, array_merge($target, [

            'app_id' => $this->appId,

            'headings' => [
                'en' => $title,
            ],

            'contents' => [
                'en' => $message,
            ],

        ]));
    }
}