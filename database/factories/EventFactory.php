<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Event>
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
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'start_time' => $this->faker->dateTimeBetween('now', '+1 month'),
            'end_time' => $this->faker->dateTimeBetween('+1 month', '+2 month'),
        ];
    }
}
