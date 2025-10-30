<?php
namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contact::create([
            'email'   => 'info@mytsv.com',
            'phone'   => '+1 630 297 7501',
            'address' => '20570 N Milwaukee Ave Deerfield IL 60015',
        ]);
    }
}
