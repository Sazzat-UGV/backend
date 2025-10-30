<?php
namespace Database\Seeders\Deployment;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('comments')->insert([
            [
                'user_id'    => 3,
                'video_id'   => 7,
                'comment'    => ':))',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id'    => 1,
                'video_id'   => 1,
                'comment'    => 'Good',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id'    => 2,
                'video_id'   => 10,
                'comment'    => 'Nice',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id'    => 37,
                'video_id'   => 29,
                'comment'    => 'ragaf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
