<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'       => fake()->sentence(),
            'description' => fake()->text(50),
            'needs_reg'   => fake()->boolean(),
            'user_id'     => function () {
                return \App\Models\User::factory()->create()->id;
            },
            'track_id'    => 1,
            'year'        => fake()->year(),
        ];
    }
}
