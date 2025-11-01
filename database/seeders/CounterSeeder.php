<?php

namespace Database\Seeders;

use App\Models\Counter;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CounterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Counter::create([
            'title1'=>'Total campaign',
            'number1'=>'1250',
            'title2'=>'Satisfied donors',
            'number2'=>'1785',
            'title3'=>'Fund raised',
            'number3'=>'4562',
            'title4'=>'Happy volunteers',
            'number4'=>'1235',
        ]);
    }
}
