<?php

namespace App\Jobs;

use App\Services\GooglePlacesService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchGoogleReviews implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $placeId
    ) {}

    /**
     * Execute the job.
     */
    public function handle(GooglePlacesService $googlePlacesService): void
    {
        $googlePlacesService->fetchAndCacheReviews($this->placeId);
    }
}
