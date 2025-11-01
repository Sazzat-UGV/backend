<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //create developer
        $developerRoleId = Role::where('slug', 'developer')->first()->id;
        $first_name = 'Asikul Islam';
        $last_name = 'Sazzat';
        User::updateOrCreate([
            'role_id' => $developerRoleId,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'slug' => Str::slug($first_name . ' ' . $last_name),
            'email' => 'developer@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('1234'),
            'remember_token' => Str::random(10),
        ]);

        //create administrator
        $administratorRoleId = Role::where('slug', 'administrator')->first()->id;
        $first_name = 'System Admin';
        $last_name = 'Name';
        User::updateOrCreate([
            'role_id' => $administratorRoleId,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'slug' => Str::slug($first_name . ' ' . $last_name),
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('1234'),
            'remember_token' => Str::random(10),
        ]);

        //create user
        $administratorRoleId = Role::where('slug', 'User')->first()->id;
        $first_name = 'System User';
        $last_name = 'Name';
        User::updateOrCreate([
            'role_id' => $administratorRoleId,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'slug' => Str::slug($first_name . ' ' . $last_name),
            'email' => 'user@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('1234'),
            'remember_token' => Str::random(10),
        ]);
        $first_name = 'System User';
        $last_name = 'Name1';
        User::updateOrCreate([
            'role_id' => $administratorRoleId,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'slug' => Str::slug($first_name . ' ' . $last_name),
            'email' => 'user1@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('1234'),
            'remember_token' => Str::random(10),
        ]);
        $first_name = 'System User';
        $last_name = 'Name2';
        User::updateOrCreate([
            'role_id' => $administratorRoleId,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'slug' => Str::slug($first_name . ' ' . $last_name),
            'email' => 'user2@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('1234'),
            'remember_token' => Str::random(10),
        ]);
    }
}
