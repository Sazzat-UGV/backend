<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            ModuleSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            GeneralSettingSeeder::class,
            SliderSeeder::class,
            SpecialSeeder::class,
            FeatureSeeder::class,
            TestimonialSeeder::class,
            CounterSeeder::class,
            FaqSeeder::class,
            VolunteerSeeder::class,
            GallerySeeder::class,
            BlogSeeder::class,
            EventSeeder::class,
            OtherPageSeeder::class,
            CauseSeeder::class,
        ]);
    }
}
