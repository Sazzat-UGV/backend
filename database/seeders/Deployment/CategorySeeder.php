<?php
namespace Database\Seeders\Deployment;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $categories = [
            'Restaurants & Catering',
            'Beauty Esthetics',
            'Physical Therapy',
            'Lawyers & Paralegals',
            'Medical Doctors',
            'Chiropractors',
            'Car Dealers',
            'Massage Therapy',
            'Ophthalmology',
            'Cars & Trucks',
            'Groceries & Delis',
            'Insurance Companies',
            'Acupuncturists',
            'Realstate Housing',
            'Electronic Stores',
            'Supermarkets Malls',
            'Accounting & Taxes',
            'Moving Companies',
            'Freight Companies',
            'Tattoos',
            'Night Clubs',
            'Schools Tutors',
            'Fitness Centers',
            'Yoga Studios',
            'Hypnotherapists',
            'Sales & Marketing',
            'IT services',
            'Video & Photography',
            'Psychology',
            'Finance & Consulting',
            'Hardware Shops',
            'Construction Services',
            'Plumbing',
            'Optometrists & Glasses',
            'Recreational activities',
            'Hair Stylists',
            'Sports Children',
            'Martial Arts',
            'Auto Mechanics',
            'Collision Centers',
            'Automotive Stores',
            'Manicure Pedicure',
            'Eyebrows Care',
            'Plastic Surgery',
            'Dry Cleaners',
            'Laundry',
            'Roofing Services',
            'Windows Cleaners',
            'Housekeeping',
            'Caregivers Companies',
            'Hospitals',
            'Veterinarians',
            'Pet Shops',
            'Daycares',
            'Pets Grooming',
            'Landscaping Services',
            'Spiritual Healing',
            'Camping Outdoors',
            'Jetski & Snowmobile',
            'Yachts Boats',
            'Hotels Motels',
            'Occupational Therapy',
            'Writers Editors',
            'Computer Repair',
            'Manufacturers',
            'Brokers',
            'Antiques',
            'Pawn Shop',
            'Titles Registration',
            'Currency Exchange',
            'Convenience Stores',
            'Book Stores',
            'Naprapathy',
            'Travel agencies',
            'Driving Schools',
            'Colleges',
            'Laboratories',
            'IV Therapy',
            'Dispensaries',
            'Printing',
            'Limousines',
            'Spa & Saloons',
        ];

        $insertData = [];
        foreach ($categories as $category) {
            $insertData[] = [
                'name'      => $category,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('categories')->insert($insertData);
    }
}
