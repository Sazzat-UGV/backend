<?php
namespace Database\Seeders;

use App\Models\Pricing;
use Illuminate\Database\Seeder;

class PricingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pricing::create([
            'uploading_video'         => '9.99',
            'uploading_youTube_link'  => '1.99',
            'onsite_account_creation' => '7.99',
        ]);
    }
}
