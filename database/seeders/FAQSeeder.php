<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $faqs = [
                [
                    'question' => 'What is your return policy?',
                    'answer' => 'Our return policy allows you to return items within 30 days of purchase for a full refund, provided they are in their original condition.'
                ],
                [
                    'question' => 'How can I track my order?',
                    'answer' => 'You can track your order using the tracking link sent to your email after purchase. Alternatively, log in to your account and check the "My Orders" section.'
                ],
                [
                    'question' => 'Do you offer international shipping?',
                    'answer' => 'Yes, we ship to most countries worldwide. Shipping costs and delivery times vary by destination.'
                ],
                [
                    'question' => 'What payment methods do you accept?',
                    'answer' => 'We accept Visa, Mastercard, PayPal, and other major credit/debit cards. For a full list, please check our payment options page.'
                ],
                [
                    'question' => 'How can I contact customer support?',
                    'answer' => 'You can reach us via email at support@example.com or call us at +123-456-7890. We’re available Monday to Friday, 9 AM to 5 PM.'
                ],
            ];
     
        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
