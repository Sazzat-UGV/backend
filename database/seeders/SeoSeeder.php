<?php
namespace Database\Seeders;

use App\Models\Seo;
use Illuminate\Database\Seeder;

class SeoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Seo::create([
            'title'       => 'MyTSV - Business Directory',
            'description' => 'Expanding from the Chicagoland area to a nationwide reach, we aim to simplify and enhance the way people find services and businesses in their local communities, fostering closer connections between businesses and residents.',
            'tags'        => json_encode([
                'business', 'local business', 'directory', 'explore',
            ]),
            'links'       => json_encode([
                [
                    'key'   => 'facebook',
                    'value' => [
                        'https://facebook.com/page1',
                        'https://facebook.com/page2',
                    ],
                ],
                [
                    'key'   => 'twitter',
                    'value' => ['https://twitter.com/myhandle'],
                ],
                [
                    'key'   => 'linkedin',
                    'value' => ['https://linkedin.com/company/page'],
                ],
            ]),

        ]);
    }
}
