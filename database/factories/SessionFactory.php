<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Session>
 */
class SessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_id'   => 1,
            'venue_id'   => fake()->numberBetween(1, 7),
            'slot_id'    => fake()->numberBetween(1, 7),
            'date_held'  => fake()->date(),
            'is_closed'  => fake()->boolean(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
