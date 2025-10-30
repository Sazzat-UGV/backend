<?php
namespace Database\Seeders;

use App\Models\FAQ;
use Illuminate\Database\Seeder;

class FAQSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            'What is MyTSV.com?'                                => 'MyTSV is a video-sharing platform designed for local businesses, professionals, and specialists to showcase their services, talents, and products through video content.',
            'Who can join MyTSV?'                               => 'Anyone! Whether you’re a business owner, freelancer, artist, or service provider in your local area, MyTSV is for you.',
            'How do I create an account?'                       => 'Click on the Sign Up button at the top right corner of the homepage and follow the registration process.',
            'Is there a fee to use MyTSV?'                      => 'Browsing and watching videos is free. We also offer free and premium plans for content creators and businesses.',
            'How do I upload a video?'                          => 'After logging in, click the Upload Video button on your dashboard and follow the steps.',
            'Can I like, share, and comment on videos?'         => 'Yes! Users can like, comment, and share videos as well as save them to favorites.',
            'Are videos moderated?'                             => 'Yes, videos are reviewed for compliance with community guidelines and inappropriate content is removed.',
            'How can I find local businesses or professionals?' => 'Use our search bar or browse by category or location.',
            'How are ratings and reviews managed?'              => 'Users can rate videos and leave feedback. Spam and abuse are monitored.',
            'I forgot my password. What should I do?'           => 'Click the Forgot Password? link on the login page and follow the instructions.',
            'Can I advertise my business on MyTSV?'             => 'Yes, we offer promoted videos, homepage features, and banner placements. Contact ads@mytsv.com for details.',
            'How do I contact support?'                         => 'Email support@mytsv.com or use the Contact Us form on our website.',
        ];
        foreach ($faqs as $key => $value) {
            FAQ::create([
                'question' => $key,
                'answer'   => $value,
            ]);
        }
    }
}
