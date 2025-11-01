<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = Category::all()->pluck('id')->toArray();
        return [
            'category_id' => Arr::random($categories),
            'title' => $this->faker->sentence(),
            'slug' => Str::slug($this->faker->sentence()),
            'description' => $this->faker->paragraph(),
            'short_description' => $this->faker->sentence(),
            'tags' => implode(',', $this->faker->words(5)),
        ];
    }
}
