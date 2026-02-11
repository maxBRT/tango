<?php

namespace Database\Factories;

use App\Models\Player;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Save>
 */
class SaveFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'player_id' => Player::factory(),
            'name' => fake()->word(),
            'data' => [
                'level' => fake()->numberBetween(1, 100),
                'score' => fake()->numberBetween(0, 999999),
            ],
        ];
    }
}
