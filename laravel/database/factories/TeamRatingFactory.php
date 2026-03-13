<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\TeamRating;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamRatingFactory extends Factory
{
    protected $model = TeamRating::class;

    public function definition(): array
    {
        return [
            'team_id' => Team::factory(),
            'rating' => $this->faker->numberBetween(1, 5),
            'feedback' => $this->faker->sentence(),
            'notified' => false,
        ];
    }
}
