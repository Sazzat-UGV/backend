<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i=1; $i<=3;$i++){
            Slider::create([
                'title'=>'Makes children happy with your small donations',
                'description'=>"Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a type and scrambled.",
                'image'=>$i.'.'.'png',
                'button_name'=>'Read More',
                'button_link'=>'#',
            ]);
        }
    }
}
