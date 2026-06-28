<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SemaphoreService
{
    public function sendOtp(string $phone, string $code): bool
    {
        $response = Http::asForm()->post('https://api.semaphore.co/api/v4/messages', [
            'apikey' => config('services.semaphore.api_key'),
            'number' => $phone,
            'message' => "Your VeriFyre login code is {$code}. It expires in 10 minutes. Do not share this code.",
        ]);

        if (!$response->successful()) {
            Log::error('Semaphore SMS send failed', [
                'phone' => $phone,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
        }

        return $response->successful();
    }
}
