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
            'name' => $this->faker->name(),
            'slug' => $this->faker->slug(),
            'short_description' => $this->faker->sentence(3),
            'description' => $this->faker->text(),
            'date' => $this->faker->date(),
            'email' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
            'time' => $this->faker->time(),
            'location' => $this->faker->address() . ', ' . $this->faker->city(),
            'map' => '<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d14607.678391110547!2d90.423296!3d23.750246399999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sbd!4v1734669167366!5m2!1sen!2sbd" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
            'price' => $this->faker->numberBetween(1, 100),
            'total_seat' => $this->faker->numberBetween(1, 100),
            'booked_seat' => $this->faker->numberBetween(1, 100),
        ];

    }
}
