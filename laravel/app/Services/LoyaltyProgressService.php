<?php

namespace App\Services;

use App\Models\CrmContact;
use App\Models\LoyaltyReward;
use Illuminate\Support\Collection;

/**
 * Generic loyalty progress service.
 * 
 * Computes progress data for a contact toward the next reward.
 * Designed to be reusable across Livewire components, email templates, API responses, etc.
 */
class LoyaltyProgressService
{
    /**
     * Get the full loyalty progress for a contact.
     *
     * Returns an array with:
     * - current_points: int
     * - program_type: string ('visits' or 'points')
     * - next_reward: array|null (name, icon, emoji, points_required, points_remaining, progress_percent)
     * - claimable_rewards: Collection of rewards the contact can currently consume
     * - all_rewards: Collection of all rewards with progress info
     */
    public static function getProgress(CrmContact $contact, string $programType, Collection $rewards): array
    {
        $currentPoints = $contact->loyalty_points;
        $unitLabel = $programType === 'visits' ? 'visites' : 'points';

        $iconMap = [
            'gift' => '🎁', 'star' => '⭐', 'coffee' => '☕', 'ticket' => '🎫',
            'percent' => '🏷️', 'cake' => '🎂', 'burger' => '🍔', 'pizza' => '🍕',
            'drink' => '🥤', 'icecream' => '🍦', 'scissors' => '✂️', 'massage' => '💆',
            'car' => '🚗', 'bag' => '👜', 'money' => '💸',
        ];

        // Build reward progress for each reward
        $allRewards = $rewards->map(function (LoyaltyReward $reward) use ($currentPoints, $iconMap) {
            $remaining = max(0, $reward->points_required - $currentPoints);
            $percent = $reward->points_required > 0
                ? min(100, round(($currentPoints / $reward->points_required) * 100))
                : 0;

            return [
                'id' => $reward->id,
                'name' => $reward->name,
                'icon' => $reward->icon ?? 'gift',
                'emoji' => $iconMap[$reward->icon ?? 'gift'] ?? '🎁',
                'points_required' => $reward->points_required,
                'points_remaining' => $remaining,
                'progress_percent' => $percent,
                'can_claim' => $currentPoints >= $reward->points_required,
            ];
        });

        // Find the next unclaimed reward (lowest points_required that is not yet claimable)
        $nextReward = $allRewards->where('can_claim', false)->sortBy('points_required')->first();

        // If all rewards are claimable, show the highest one as "completed"
        if (!$nextReward && $allRewards->isNotEmpty()) {
            $nextReward = $allRewards->sortByDesc('points_required')->first();
        }

        $claimable = $allRewards->where('can_claim', true)->values();

        return [
            'current_points' => $currentPoints,
            'program_type' => $programType,
            'unit_label' => $unitLabel,
            'next_reward' => $nextReward,
            'claimable_rewards' => $claimable,
            'all_rewards' => $allRewards->values(),
        ];
    }
}
