<?php
namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'              => 'System Admin',
            'email'             => 'admin@gmail.com',
            'role'              => 'ADMIN',
            'email_verified_at' => now(),
            'password'          => Hash::make('1234'),
        ]);
        $users = [
            ['channel_name' => 'TSV', 'name' => 'Admin Admin', 'email' => 'admin@admin.com2', 'password' => '$2y$12$EfYYeTDOmW2qEorvW9QWr.LVlnOU/N2CzNX8zX2vzS4u041c9qHw.', 'role' => 'ADMIN'],
            ['channel_name' => 'Irakli', 'name' => 'Irakli', 'email' => 'iraklisesit@gmail.com', 'password' => '$2y$12$LfIAUylrrYSYg9Er8kZnOeyxuGIC9RWtf.JStWvgSMBPG7D55dSo2', 'role' => 'ADMIN'],
            ['channel_name' => 'esaia gafrindashvili', 'name' => 'esaia gafrindashvili', 'email' => 'esaiagafrindashvili@gmail.com', 'password' => '$2y$12$HAhFNUreNZ7I.nvs6RdO6.MKKjiwOcr6FGfUU2NBu8NizOoA0azE6', 'role' => 'USER'],
            ['channel_name' => 'Teaching Therapy', 'name' => 'Teaching Therapy', 'email' => 'aybekizzatov@gmail.com', 'password' => '$2y$12$JmjRwB6J8Ii5bQv4samsk.I34ekpmikJQv2H7iGXiZl26JVGLao5W', 'role' => 'ADMIN'],
            ['channel_name' => 'Egnate Tsaava', 'name' => 'Egnate Tsaava', 'email' => 'egoooo911@gmail.com', 'password' => '$2y$12$9bznDJdfTxZlSdb./K/qWuDrjVnN1s6R89T.9yf639Faot.KQT8fe', 'role' => 'USER'],
            ['channel_name' => 'Illinois business', 'name' => 'Russell', 'email' => 'rasulizzatov@gmail.com', 'password' => '$2y$12$cBR7Smrmj7qNt64qe2segu7wQCIcWg70y16CGamdYcLakTwLssfT6', 'role' => 'USER'],
            ['channel_name' => 'Illinois Specialists', 'name' => 'Ulugbek Izzatov', 'email' => 'ulugbekizzatov9@gmail.com', 'password' => '$2y$12$i68enucftyI48n06UBpWX.8tKW.9FiXi13i0bBNIupQKsQjUDUlN6', 'role' => 'USER'],
            ['channel_name' => 'Amazonn', 'name' => 'Alex', 'email' => 'sungates6@gmail.com', 'password' => '$2y$12$Svnpr/huRjy9gvT5PZrkFed0E5SYOrJgkkIdn0I9xyx5mHp/7GTkG', 'role' => 'USER'],
            ['channel_name' => 'Co-pilot', 'name' => 'Ivan', 'email' => 'massage.classes.courses@gmail.com', 'password' => '$2y$12$LavfRmmUKrN32FNnPvqOQONwHyHa8XgOiUUuPX7.skNeH.9i1U8Zq', 'role' => 'USER'],
            ['channel_name' => 'Burgundy', 'name' => 'Robert', 'email' => 'djanvantari@gmail.com', 'password' => '$2y$12$VzCl4f95HNQ3YIEmAyBI3.OuOi.IUYRfm0kT5Nd1sWUhff8ICzWL.', 'role' => 'USER'],
            ['channel_name' => 'Smart System', 'name' => 'Sophia', 'email' => 'aybekus98@gmail.com', 'password' => '$2y$12$IBX3YxfMpvtuEITuEmYnu.AB36ruJFe2X5KHjk5Mnl10SHd2tZfRS', 'role' => 'USER'],
            ['channel_name' => 'Sungates Portal', 'name' => 'Svetlana', 'email' => 'sungatesportal@gmail.com', 'password' => '$2y$12$hSTeBMOaM6IiCPAvxhggKOl4yZ/goxza4kNsNtf34R7ILtqP3mK1u', 'role' => 'USER'],
            ['channel_name' => 'Happyme', 'name' => 'Cristian', 'email' => 'happychildhappychildhappyparents@gmail.com', 'password' => '$2y$12$3tkGKWO7sa4XiTeuFHEB3uNwT7AKliDFv8OpqT7L3ZNfS5kNLVaLO', 'role' => 'USER'],
            ['channel_name' => 'Cinematic', 'name' => 'Rustam', 'email' => 'rustam930r@gmail.com', 'password' => '$2y$12$c9TPazKD0pMWfl4k/g4bTOm9MNrT5bQJSHv.3iKiTKFw1gakyhWee', 'role' => 'USER'],
            ['channel_name' => 'Ля Иля', 'name' => 'Ля Иля', 'email' => 'ddsundari5@gmail.com', 'password' => '$2y$12$c1XD1g8XsNIDCFvHM0BU/uzwVgq82E6UFyQ9PDh1zFQUXgbO.SpVG', 'role' => 'USER'],
            ['channel_name' => 'Lotus', 'name' => 'La', 'email' => 'raroson6@gmail.com', 'password' => '$2y$12$xyI8nLEeVR2AxLN9oSukFembG5kOmv/QxgsVaJAGfOGZOoI2Rns6K', 'role' => 'USER'],
            ['channel_name' => 'Lotus', 'name' => 'Lo', 'email' => 'vyramans56@gmail.com', 'password' => '$2y$12$.Pnjy5a9fDX6Sov6Clcup.yeTGYuXfV7wi2MhvhO3EaV2hECIdj52', 'role' => 'USER'],
            ['channel_name' => 'Veyla', 'name' => 'Veya', 'email' => 'milahans6@yahoo.com', 'password' => '$2y$12$00Jb9GW8AFNJ8JQwyWfv8usPZx.Ai0RJ/CpxJIsukP5V4H85u8f.K', 'role' => 'USER'],
            ['channel_name' => 'Melon', 'name' => 'Don', 'email' => 'sunrises6@gmail.com', 'password' => '$2y$12$TU5kVGF2RztH20eWxf7jCuRJnQi.q0BbkeRObD.2qzKk0Y1.sBRq.', 'role' => 'USER'],
            ['channel_name' => 'Irakli', 'name' => 'Irakli', 'email' => 'isesita2006@gmail.com', 'password' => '$2y$12$gqLOOQkU3h2HvWu74DpkD.EHUFwoE51VgsNpFsEFgQTZDH1TJyy6m', 'role' => 'USER'],
            ['channel_name' => 'ramiz izzatov', 'name' => 'ramiz izzatov', 'email' => 'ramizizzy@gmail.com', 'password' => '$2y$12$F3OtqhN4jqjPir0rHzUfiOGMV3wI03hXpV7sFbZovmelH6jnTFIQ.', 'role' => 'USER'],
            ['channel_name' => 'Inga Tice', 'name' => 'Inga Tice', 'email' => 'ticeinga@gmail.com', 'password' => '$2y$12$IemJADmx7Wd/cGhGnZnxZe0nZGFiz9PJMWjLACs7WwegsF.8meXZ6', 'role' => 'USER'],
            ['channel_name' => 'George George', 'name' => 'George George', 'email' => 'giorgi6636@gmail.com', 'password' => '$2y$12$zrOOResuQ3OX9IsCaVEeO.3nkomu68j7uZD1npfOOrCJdIk35HUgu', 'role' => 'USER'],
            ['channel_name' => 'System User', 'name' => 'System User', 'email' => 'user@gmail.com', 'password' => '$2y$12$S9Fl9bPFvZDyqdef6EdzRuUljRdDpg4zZmvlUI46BM3.XsSJ0ZnFa', 'role' => 'USER'],
            ['channel_name' => 'Kazi Omar Faruk', 'name' => 'Kazi Omar Faruk', 'email' => 'kaziomar.bdcalling@gmail.com', 'password' => '$2y$12$0MwmzJFm/IDX5np7Wo3lJelPSow7EuwQjnj7/wf5XTbCX6T/OSO0O', 'role' => 'USER'],
            ['channel_name' => 'bbb', 'name' => 'Aybek', 'email' => 'aybekizzatov@yahoo.com', 'password' => '$2y$12$1m9xnIouk57DFkaLqLoMY.SQC2GZB6oAVEIjmJe.25CfCC1cJzqt.', 'role' => 'USER'],
            ['channel_name' => 'Kazi Omar Faruk', 'name' => 'Kazi Omar Faruk', 'email' => 'softeng.kaziomar@gmail.com', 'password' => '$2y$12$jUccLc8lw3OXMXJTvQxm1ejgV0jEgUwh3KxIzIxhjJUNlygDOc4aC', 'role' => 'USER'],
            ['channel_name' => 'dfdfd', 'name' => 'Vera Ortiz', 'email' => 'tanjim@gmail.com', 'password' => '$2y$12$RTBUhma348.DEqSusbFVzuxhq3L56N.7Dtd70OZd2FaVpHXeQtai.', 'role' => 'USER'],
            ['channel_name' => 'Eagan Finch', 'name' => 'Yeo Wilkerson', 'email' => 'xuxylepy@mailinator.com', 'password' => '$2y$12$iuMKaAEsxe5m3Iw2X/FEuOuFepw4RH6TbD4TdnrccXnQ9XGJt6vya', 'role' => 'USER'],
            ['channel_name' => 'Colin Gray', 'name' => 'Natalie Mayer', 'email' => 'jybakyx@mailinator.com', 'password' => '$2y$12$mNGhjWK2VMll.kIngPkPNOcC3FjSgQ41FXsWG2zuWw47hcna6AAoK', 'role' => 'USER'],
            ['channel_name' => 'Test', 'name' => 'Test', 'email' => 'iraklisesit2@gmail.com', 'password' => '$2y$12$57MThaMD.r52czrXi1kka.B8l6w6rZuQtEqY967b59AtdoANVCDEi', 'role' => 'USER'],
            ['channel_name' => 'PHP Mailer', 'name' => 'PHP Mailer', 'email' => 'phpmailer144@gmail.com', 'password' => '$2y$12$6fVMkzYRrMoEXBTcAKZGx.e12e3sWw04BC6FWWX7RBD5YcYiQqMKG', 'role' => 'USER'],
            ['channel_name' => 'Kazi Omar Faruk', 'name' => 'Kazi Omar Faruk', 'email' => 'kaziomar520@gmail.com', 'password' => '$2y$12$44.b7d6qoXCnLW.xoVDTU..8WDRT1/A.yr2.8.FFShh6wwTSmD1J6', 'role' => 'USER'],
            ['channel_name' => 'PHP Mailer', 'name' => 'PHP Mailer', 'email' => 'phpmailer145@gmail.com', 'password' => '$2y$12$3ori2McwDEf.QkFf3nMus.0rX3p1/Avh.Srkh/woBwuJ9gtV0BOeC', 'role' => 'USER'],
            ['channel_name' => 'Yo yo', 'name' => 'Yo Yo Jon', 'email' => 'sasikac118@cyluna.com', 'password' => '$2y$12$XdpA5erDrrA.8d7IcvlMH.BoA.Ms4rfjo14JgTOgfd9Pqg7yDxhc6', 'role' => 'USER'],
            ['channel_name' => 'Md. Abid Hasan', 'name' => 'Md. Abid Hasan', 'email' => 'abid.bdcalling@gmail.com', 'password' => '$2y$12$QehpHNj5Nben/i3DsWuqH.cvjdsQfmIu1ESx9S3bU7DSii9.zAroa', 'role' => 'USER'],
            ['channel_name' => 'Julfiker Islam', 'name' => 'Julfiker Islam', 'email' => 'julfiker755.bd@gmail.com', 'password' => '$2y$12$UWltiC2Y24UeiB7.2ovOre1EW4EZ7JloRTJqqlIK/hszwC9l6Pgni', 'role' => 'USER'],
        ];

        foreach ($users as $user) {
             $fileUpload    = new FileUploadService('public_path');
            DB::table('users')->insert([
                'channel_name'        => $user['channel_name'],
                'name'                => $user['name'],
                'email'               => $user['email'],
                'email_verified_at'   => Carbon::now(),
                'password'            => $user['password'],
                'role'                => $user['role'],
                'contact'             => null,
                'bio'                 => null,
                'locations'         => json_encode([
                [
                    'type'     => 'head-office',
                    'location' => 'Dhaka, Bangladesh',
                    'lat'      => '23.8103',
                    'long'     => '90.4125',
                ],
                [
                    'type'     => 'branch',
                    'location' => 'Chittagong, Bangladesh',
                    'lat'      => '22.3569',
                    'long'     => '91.7832',
                ],
            ]),
              'services'          => json_encode([
                'service1',
                'service2',
                'service3',
                'service4',
                'service5',
            ]),
                'avatar'=>$fileUpload->setPath('uploads/user/')->generateUserAvatar($user['channel_name']),
                'cover_image'=>'default_cover_image.jpg',
                'registration_type'   => 'normal',
                'is_pay'              => 0,
                'pause_watch_history' => 0,
                'status'              => 'active',
                'created_at'          => now(),
                'updated_at'          => now(),
            ]);
        }

        // User::create([
        //     'name'              => 'System User',
        //     'channel_name'      => 'Demo Channel',
        //     'email'             => 'user@gmail.com',
        //     'contact'           => '+9856425662',
        //     'bio'               => 'Lorem ipsum dolor sit amet consectetur. Pretium gravida risus enim suspendisse. Id id molestie dictum mauris tincidunt. Molestie posuere quam sapien luctus. Consectetur tincidunt tincidunt fermentum ut risus quam. Suspendisse vivamus laoreet ornare molestie iaculis vitae urna. Diam augue sed rhoncus nec egestas praesent sit orci. Dui ut morbi nulla ipsum eget semper quis non. Fames nullam aliquam pellentesque tortor nulla. Id eget dolor sagittis aenean proin.',
        //     'role'              => 'USER',
        //     'services'          => json_encode([
        //         'service1',
        //         'service2',
        //         'service3',
        //         'service4',
        //         'service5',
        //     ]),
        //     'email_verified_at' => now(),
        //     'password'          => Hash::make('1234'),
        //     'locations'         => json_encode([
        //         [
        //             'type'     => 'head-office',
        //             'location' => 'Dhaka, Bangladesh',
        //             'lat'      => '23.8103',
        //             'long'     => '90.4125',
        //         ],
        //         [
        //             'type'     => 'branch',
        //             'location' => 'Chittagong, Bangladesh',
        //             'lat'      => '22.3569',
        //             'long'     => '91.7832',
        //         ],
        //     ]),
        // ]);
    }
}
