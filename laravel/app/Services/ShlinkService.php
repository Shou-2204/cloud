<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ShlinkService
{
    protected string $url;
    protected string $apiKey;

    public function __construct()
    {
        $this->url = config('services.shlink.url') ?? '';
        $this->apiKey = config('services.shlink.api_key') ?? '';
    }

    /**
     * Create a short URL for the given long URL.
     *
     * @param string $longUrl
     * @param array $tags
     * @return string|null
     */
    public function createShortUrl(string $longUrl, array $tags = []): ?string
    {
        if (empty($this->url) || empty($this->apiKey)) {
            Log::warning('Shlink configuration is missing.');
            return null;
        }

        try {
            $response = Http::withHeaders([
                'X-Api-Key' => $this->apiKey,
                'Accept' => 'application/json',
            ])->post("{$this->url}/rest/v3/short-urls", [
                'longUrl' => $longUrl,
                'tags' => $tags,
                'crawlable' => true,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['shortUrl'] ?? null;
            }

            Log::error('Shlink API Error: ' . $response->body());
            return null;

        } catch (\Exception $e) {
            Log::error('Shlink Exception: ' . $e->getMessage());
            return null;
        }
    }
}
