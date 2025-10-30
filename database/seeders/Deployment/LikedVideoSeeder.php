<?php

namespace Database\Seeders\Deployment;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LikedVideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('liked_videos')->insert([

            [
                'user_id'    => 34,
                'video_id'   => 63,
                'created_at' => '2025-04-23 10:57:58',
                'updated_at' => '2025-04-23 10:58:10',
            ],
            [
                'user_id'    => 38,
                'video_id'   => 13,
                'created_at' => '2025-04-23 10:57:58',
                'updated_at' => '2025-04-23 10:58:10',
            ],
        ]);
    }
}
