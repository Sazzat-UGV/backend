<?php

namespace Database\Seeders;

use App\Models\Special;
use Illuminate\Database\Seeder;

class SpecialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Special::create([
            'heading' => 'A world where poverty will not exists',
            'sub_heading' => 'We are the largest crowdfunding',
            'text' => 'Lorem ipsum dolor sit amet, consectetur notted adipisicing elit sed do eiusmod tempor incididunt ut labore.<br> Lorem ipsum dolor sit amet, consectetur notted adipisicing elit sed do eiusmod tempor incididunt ut labore et simply free text dolore magna aliqua lonm andhn.',
            'photo' => 'special.png',
            'button_name' => 'Learn more',
            'button_link' => '#',
            'video_id' => 'R3GfuzLMPkA',
            'video_button_name' => 'How we work',
        ]);
    }
}
