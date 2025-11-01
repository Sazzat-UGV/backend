<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Feature::create([
            'title' => 'Save planet',
            'text' => 'Proident culpa deserunt consequat nisi veniam cillum eu labore laborum laborum. Reprehenderit veniam ex non sit magna pariatur officia sunt.',
        ]);
        Feature::create([
            'title' => "Protect children's",
            'text' => 'Proident culpa deserunt consequat nisi veniam cillum eu labore laborum laborum. Reprehenderit veniam ex non sit magna pariatur officia sunt.',
        ]);
        Feature::create([
            'title' => 'Donate for poor',
            'text' => 'Proident culpa deserunt consequat nisi veniam cillum eu labore laborum laborum. Reprehenderit veniam ex non sit magna pariatur officia sunt.',
        ]);
    }
}
