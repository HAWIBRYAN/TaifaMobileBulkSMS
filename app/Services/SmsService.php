<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class SmsService
{
    protected $baseUrl;
    protected $username;
    protected $password;
    protected $sender;
    protected $callbackUrl;

    public function __construct()
    {
        $this->baseUrl     = config('services.sms.base_url');
        $this->username    = config('services.sms.username');
        $this->password    = config('services.sms.password');
        $this->sender      = config('services.sms.sender');
        $this->callbackUrl = config('services.sms.callback');
    }

    /**
     * Get Bearer token (cached for 55 mins to avoid frequent logins)
     */
    private function getToken()
    {
        return Cache::remember('sms_token', 55 * 60, function () {
            $response = Http::post($this->baseUrl . '/auth/token', [
                'username' => $this->username,
                'password' => $this->password,
            ]);

            if ($response->successful()) {
                return $response->body(); // API returns token as plain string
            }

            throw new \Exception('Failed to authenticate with SMS API: ' . $response->body());
        });
    }

    /**
     * Send Bulk SMS
     */
    public function sendSms(array $recipients, string $message)
    {
        $token = $this->getToken();

        $payload = [
            "title"     => "Api Message",
            "content"   => $message,
            "addresses" => $recipients,
            "sender"    => $this->sender,
            "sendTime"  => now()->toISOString(),
            "dnd"       => 0,
            "isDeliveryReport" => true,
            "callbackUrl" => $this->callbackUrl,
        ];

        $response = Http::withToken($token)
            ->post($this->baseUrl . '/api/sms/bulk', $payload);

        if ($response->failed()) {
            throw new \Exception('SMS sending failed: ' . $response->body());
        }

        return $response->json();
    }
}
