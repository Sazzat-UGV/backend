<?php

namespace Database\Factories;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Volunteer>
 */
class VolunteerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $links = ['#', fake()->url(),''];
        return [
            'name' => fake()->name(),
            'title' => fake()->title(),
            'facebook' => Arr::random($links),
            'twitter' => Arr::random($links),
            'instagram' => Arr::random($links),
            'linkedin' => Arr::random($links),
        ];
    }
}
