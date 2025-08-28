// app/Services/TaifaSmsService.php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class TaifaSmsService
{
    protected string $authUrl = 'https://developer.taifamobile.co.ke/auth/token';
    protected string $smsUrl  = 'https://developer.taifamobile.co.ke/api/sms/bulk';

    public function authenticate(): string
    {
        return Cache::remember('taifa_token', now()->addMinutes(55), function () {
            $response = Http::timeout(30)->post($this->authUrl, [
                'username' => env('TAIFA_USERNAME'),
                'password' => env('TAIFA_PASSWORD'),
            ]);

            if ($response->failed()) {
                throw new \Exception('Authentication failed: '.$response->body());
            }

            return $response->json()['token'];
        });
    }

    public function sendSms(array $payload): array
    {
        $token = $this->authenticate();

        $response = Http::withHeaders([
                'Authorization' => $token,
                'Content-Type' => 'application/json',
            ])
            ->timeout(30)
            ->post($this->smsUrl, $payload);

        if ($response->failed()) {
            throw new \Exception('SMS sending failed: ' . $response->body());
        }

        return $response->json();
    }
}
