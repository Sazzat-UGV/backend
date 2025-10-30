<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Page::create([
            'type' => 'Terms & Conditions',
            'text' => '
                <p>Welcome to mytsv.com. By accessing or using our website, you agree to comply with and be bound by the following terms and conditions. Please read them carefully before using the site.</p>

                <h2>1. Acceptance of Terms</h2>
                <p>By accessing or using mytsv.com, you agree to be legally bound by these Terms and Conditions, our Privacy Policy, and any other policies we post. If you do not agree with any part of these terms, please do not use our website.</p>

                <h2>2. Use of the Website</h2>
                <p>You agree to use mytsv.com only for lawful purposes and in a way that does not infringe on the rights of, restrict, or inhibit anyone else\'s use of the website. You must not misuse the site by introducing viruses, attempting unauthorized access, or engaging in any activity that harms our platform or users.</p>

                <h2>3. User Accounts</h2>
                <p>If you create an account with us, you are responsible for maintaining the confidentiality of your login credentials and for all activities that occur under your account. You agree to notify us immediately of any unauthorized use of your account.</p>

                <h2>4. Intellectual Property</h2>
                <p>All content on mytsv.com, including text, graphics, logos, images, and software, is the property of MyTSV or its content suppliers and is protected by copyright, trademark, and other laws. You may not copy, distribute, or use our content without our prior written consent.</p>

                <h2>5. User-Generated Content</h2>
                <p>If you post or submit content (text, images, etc.) to the site, you grant MyTSV a non-exclusive, royalty-free, worldwide license to use, display, and distribute your content. You must own the rights to any content you submit and agree not to post anything unlawful, offensive, or misleading.</p>

                <h2>6. Third-Party Links</h2>
                <p>Our website may contain links to third-party sites. We are not responsible for the content, accuracy, or privacy practices of those sites. Access them at your own risk.</p>

                <h2>7. Limitation of Liability</h2>
                <p>MyTSV is not liable for any direct, indirect, incidental, or consequential damages arising from your use of or inability to use our website or services. All content is provided “as is” without warranties of any kind. </p>

                <h2>8. Modifications to Terms</h2>
                <p>We reserve the right to update these Terms and Conditions at any time. Changes will be posted on this page with a revised date. Your continued use of the site after such changes indicates your acceptance of the new terms.</p>

                <h2>9. Termination</h2>
                <p>We may suspend or terminate your access to mytsv.com without notice if we believe you have violated these Terms or engaged in harmful conduct.</p>

                <h2>10. Governing Law</h2>
                <p>These Terms and Conditions are governed by and interpreted in accordance with the laws of the State of Illinois, United States.</p>
            ',
        ]);
    }
}
