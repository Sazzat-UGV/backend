<?php
namespace Database\Seeders;

use App\Models\AboutUs;
use Illuminate\Database\Seeder;

class AboutUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $about_us = [
            [
                'icon'        => 'our_mission.png',
                'title'       => 'Our Mission',
                'description' => '<p>To empower individuals and businesses through a dynamic, user-focused platform that fosters growth, creativity, and meaningful connections across communities.</p>',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'icon'        => 'our_story.png',
                'title'       => 'Our Story',
                'description' => '<p>Founded with a vision to bring people and ideas together, MyTSV began as a local project with a big dream. What started as a small initiative to highlight community talent and services in Chicagoland has now grown into a multi-faceted platform serving users from all walks of life.<br><br>We noticed a gap in platforms that balance visibility, usability, and community. So, we set out to build a space that not only showcases talent and services but also encourages collaboration and innovation.<br><br>Over the years, we&rsquo;ve expanded our offerings, refined our technology, and stayed committed to the needs of our growing user base&mdash;all while keeping our core values front and center.</p>',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'icon'        => 'meet_with_the_team.png',
                'title'       => 'Meet with the Team',
                'description' => '<p>Behind MyTSV is a passionate team of creators, developers, and community builders. We come from diverse backgrounds, but we&rsquo;re united by one goal: to make mytsv.com a place where ideas come to life and connections lead to real impact.<br><br>We&rsquo;re designers and storytellers, strategists and support heroes, all working together to make your experience seamless, enriching, and inspiring.</p>',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'icon'        => 'why_choose _myTsv.png',
                'title'       => 'Why choose MyTsv ?',
                'description' => '<ul>
    <li><strong>User-First Design:</strong> We&rsquo;re constantly evolving to make sure your experience is smooth and meaningful.</li>
    <li><strong>Community Focused:</strong> We highlight real people, real businesses, and real stories.</li>
    <li><strong>Versatility: </strong>Whether you&apos;re promoting a service, launching a project, or exploring new trends, there&rsquo;s a place for you here.</li>
</ul>
<p><br></p>',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'icon'        => 'join_us.png',
                'title'       => 'Join Us',
                'description' => '<p>Whether you&rsquo;re a local business owner, a creative mind, or someone searching for inspiration&mdash;MyTSV is your stage. Explore, connect, grow. We&rsquo;re glad you&rsquo;re here.</p>',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ];

        AboutUs::insert($about_us);
    }
}
