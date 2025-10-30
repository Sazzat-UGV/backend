<?php
namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Database\Seeders\Deployment\CategorySeeder;
use Database\Seeders\Deployment\CommentSeeder;
use Database\Seeders\Deployment\LikedVideoSeeder;
use Database\Seeders\Deployment\VideoSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            AboutUsSeeder::class,
            PageSeeder::class,
            FAQSeeder::class,
            ContactSeeder::class,
            CategorySeeder::class,
            BlogSeeder::class,
            PricingSeeder::class,
            BannerSeeder::class,
            SeoSeeder::class,
            StateSeeder::class,
            CitySeeder::class,
            SystemSettingSeeder::class,
            VideoSeeder::class,
            CommentSeeder::class,
            LikedVideoSeeder::class,
        ]);
    }
}
