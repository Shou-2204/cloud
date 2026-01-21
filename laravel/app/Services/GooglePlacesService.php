<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class GooglePlacesService
{
    /**
     * Get reviews for a Google Place.
     *
     * @param string $placeId Google Place ID
     * @param string $apiKey Google API Key
     * @return array{reviews: array, rating: float|null, total_reviews: int|null, error: string|null}
     */
    public function getPlaceReviews(string $placeId, string $apiKey): array
    {
        $cacheKey = "google_reviews_{$placeId}";

        return Cache::remember($cacheKey, now()->addHour(), function () use ($placeId, $apiKey) {
            try {
                $response = Http::get('https://maps.googleapis.com/maps/api/place/details/json', [
                    'place_id' => $placeId,
                    'fields' => 'reviews,rating,user_ratings_total,name',
                    'key' => $apiKey,
                    'language' => 'fr',
                ]);

                if (!$response->successful()) {
                    return [
                        'reviews' => [],
                        'rating' => null,
                        'total_reviews' => null,
                        'name' => null,
                        'error' => 'Erreur de connexion à l\'API Google',
                    ];
                }

                $data = $response->json();

                if (($data['status'] ?? '') !== 'OK') {
                    $errorMessage = match ($data['status'] ?? 'UNKNOWN') {
                        'INVALID_REQUEST' => 'Requête invalide',
                        'OVER_QUERY_LIMIT' => 'Quota API dépassé',
                        'REQUEST_DENIED' => 'Clé API invalide ou non autorisée',
                        'NOT_FOUND' => 'Établissement non trouvé',
                        default => 'Erreur Google: ' . ($data['status'] ?? 'Inconnue'),
                    };

                    return [
                        'reviews' => [],
                        'rating' => null,
                        'total_reviews' => null,
                        'name' => null,
                        'error' => $errorMessage,
                    ];
                }

                $result = $data['result'] ?? [];

                return [
                    'reviews' => $result['reviews'] ?? [],
                    'rating' => $result['rating'] ?? null,
                    'total_reviews' => $result['user_ratings_total'] ?? null,
                    'name' => $result['name'] ?? null,
                    'error' => null,
                ];
            } catch (\Exception $e) {
                return [
                    'reviews' => [],
                    'rating' => null,
                    'total_reviews' => null,
                    'name' => null,
                    'error' => 'Erreur: ' . $e->getMessage(),
                ];
            }
        });
    }

    /**
     * Clear cached reviews for a place.
     */
    public function clearCache(string $placeId): void
    {
        Cache::forget("google_reviews_{$placeId}");
    }
}
