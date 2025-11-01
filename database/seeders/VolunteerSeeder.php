<?php

namespace Database\Seeders;

use App\Models\Volunteer;
use Database\Factories\VolunteerFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VolunteerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Volunteer::factory()->count(20)->create();
    }
}
