<?php

namespace Database\Seeders;

use App\Models\OtherPage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OtherPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OtherPage::create([
            'terms_condition'=>'No Terms & Conditions',
            'privacy_policy'=>'No Privacy Policy'
        ]);
    }
}
