<?php

namespace Database\Seeders;

use App\Models\GeneralSetting;
use Illuminate\Database\Seeder;

class GeneralSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GeneralSetting::updateOrCreate([
            'site_logo' => 'logo.png',
            'site_favicon' => 'favicon.png',
            'breadcrumb_image' => 'breadcrumb.jpg',
        ]);
    }
}
