<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GooglePlacesService
{
    private ?string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.google.places_api_key');
    }

    /**
     * Check if the service is configured.
     */
    public function isConfigured(): bool
    {
        return ! empty($this->apiKey);
    }

    /**
     * Get reviews for a Google Place using Places API (New).
     *
     * @param  string  $placeId  Google Place ID
     * @return array{reviews: array, rating: float|null, total_reviews: int|null, error: string|null}
     */
    public function getPlaceReviews(string $placeId): array
    {
        if (! $this->isConfigured()) {
            return [
                'reviews' => [],
                'rating' => null,
                'total_reviews' => null,
                'name' => null,
                'error' => 'service_not_configured',
            ];
        }

        $cacheKey = "google_reviews_{$placeId}";

        // Return cached data if available
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        try {
            // Places API (New) endpoint
            $url = "https://places.googleapis.com/v1/places/{$placeId}";

            Log::info('Google Places API Request', ['endpoint' => 'place_details', 'place_id' => $placeId]);

            $response = Http::timeout(10)
                ->withHeaders([
                    'X-Goog-Api-Key' => $this->apiKey,
                    'X-Goog-FieldMask' => 'id,displayName,rating,userRatingCount,reviews',
                    'Accept-Language' => 'fr',
                    'Referer' => config('app.url'),
                ])->get($url);

            Log::info('Google Places API Response', ['status' => $response->status()]);

            if (! $response->successful()) {
                $errorBody = $response->json();
                $errorMessage = $errorBody['error']['message'] ?? $response->reason();

                return [
                    'reviews' => [],
                    'rating' => null,
                    'total_reviews' => null,
                    'name' => null,
                    'error' => 'Erreur Google API: '.$errorMessage,
                ];
            }

            $data = $response->json();

            // Mapping new API response to our structure
            $reviews = collect($data['reviews'] ?? [])->map(function ($review) {
                return [
                    'author_name' => $review['authorAttribution']['displayName'] ?? 'Anonyme',
                    'author_url' => $review['authorAttribution']['uri'] ?? null,
                    'profile_photo_url' => $review['authorAttribution']['photoUri'] ?? null,
                    'rating' => $review['rating'] ?? 0,
                    'relative_time_description' => $review['relativePublishTimeDescription'] ?? '',
                    'text' => $review['text']['text'] ?? ($review['originalText']['text'] ?? ''),
                    'time' => strtotime($review['publishTime'] ?? 'now'),
                ];
            })->toArray();

            $result = [
                'reviews' => $reviews,
                'rating' => $data['rating'] ?? null,
                'total_reviews' => $data['userRatingCount'] ?? null,
                'name' => $data['displayName']['text'] ?? null,
                'error' => null,
            ];

            // Only cache successful results
            Cache::put($cacheKey, $result, now()->addWeek());

            return $result;

        } catch (\Exception $e) {
            return [
                'reviews' => [],
                'rating' => null,
                'total_reviews' => null,
                'name' => null,
                'error' => 'Erreur: '.$e->getMessage(),
            ];
        }
    }

    /**
     * Clear cached reviews for a place.
     */
    public function clearCache(string $placeId): void
    {
        Cache::forget("google_reviews_{$placeId}");
    }
}
