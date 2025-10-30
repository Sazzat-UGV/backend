<?php
namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Beauty esthetics',
            'Restaurant & Catering',
            'Antiques',
            'Hair stylists',
            'Supermarket malls',
            'Electronic stores',
            'Auto mechanics',
            'Medical doctors',
        ];
        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
            ]);
        }
    }
}
