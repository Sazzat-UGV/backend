<?php

namespace Database\Seeders;

use App\Models\gallery;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            Gallery::create([
                "title" => $faker->sentence,
            ]);
        }
    }
}
