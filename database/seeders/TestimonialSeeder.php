<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Testimonial::create([
            'name' => 'David connley',
            'designation' => 'General Manager',
            'comment' => 'Commodo aliqua minim id do aute aliquip ex aliquip aliqua nostrud ipsum. Esse et conseq dolor anim esse dolore. Voluptate consectetur consectetur veniam ad aliqua.',
            'rating' => 4,
        ]);
        Testimonial::create([
            'name' => 'Selina Madis',
            'designation' => 'Operation Officer',
            'comment' => 'Commodo aliqua minim id do aute aliquip ex aliquip aliqua nostrud ipsum. Esse et conseq dolor anim esse dolore. Voluptate consectetur consectetur veniam ad aliqua.',
            'rating' => 5,
        ]);
        Testimonial::create([
            'name' => 'Harry Gonzelo',
            'designation' => 'General Manager',
            'comment' => 'Commodo aliqua minim id do aute aliquip ex aliquip aliqua nostrud ipsum. Esse et conseq dolor anim esse dolore. Voluptate consectetur consectetur veniam ad aliqua.',
            'rating' => 3,
        ]);
    }
}
