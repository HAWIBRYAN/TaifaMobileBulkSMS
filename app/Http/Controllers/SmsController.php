<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SmsController extends Controller
{
    private $apiBase = "API DEV URL HERE";
    private $username = "TAIFAMOBILE USERNAME";
    private $password = " ";

    // Show SMS dashboard page
    public function index()
    {
        return view('sms.index');
    }

    // Get Token from Taifa API
    private function getToken()
    {
        $response = Http::withHeaders([
            "Content-Type" => "application/json"
        ])->post("{$this->apiBase}/auth/token", [
            "username" => $this->username,
            "password" => $this->password,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            return $data['token'];
        }

        return null;
    }

    // Send SMS
    public function send(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'addresses' => 'required|array',
            'sender' => 'required|string',
        ]);

        $token = $this->getToken();

        if (!$token) {
            return back()->with('error', 'Failed to authenticate with Taifa API');
        }

        $payload = [
            "title" => $request->title ?? "Laravel SMS",
            "content" => $request->content,
            "addresses" => $request->addresses,
            "sender" => $request->sender,
            "dnd" => $request->dnd ?? 0,
            "sendTime" => now()->toISOString(),
            "isDeliveryReport" => true,
            "callbackUrl" => route('sms.callback'),
        ];

        $response = Http::withHeaders([
            "Content-Type" => "application/json",
            "Authorization" => $token
        ])->post("{$this->apiBase}/api/sms/bulk", $payload);

        return back()->with('response', $response->json());
    }

    // Handle callback from Taifa API
    public function callback(Request $request)
    {
        \Log::info("Taifa SMS Callback:", $request->all());

        return response()->json([
            "status" => "success",
            "received" => $request->all()
        ]);
    }
}
