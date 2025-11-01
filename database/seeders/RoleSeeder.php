<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //create a developer role and assign all permission on it
        $developerPermission = Permission::select('id')->get();
        Role::updateOrCreate([
            'name' => 'Developer',
            'slug' => Str::slug('Developer'),
            'note' => "Developer has all permissions",
            'is_deletable' => false,
            'status' => true,
        ])->permissions()->sync($developerPermission->pluck('id'));

        //create a administrator role
        Role::updateOrCreate([
            'name' => 'Administrator',
            'slug' => Str::slug('Administrator'),
            'note' => 'Administrator has all permissions',
            'is_deletable' => false,
            'status' => true,
        ]);

        //create a manager role
        Role::updateOrCreate([
            'name' => 'Manager',
            'slug' => Str::slug('Manager'),
            'note' => "Manager have some permission",
            'is_deletable' => true,
            'status' => false,
        ]);

        //create a user role
        Role::updateOrCreate([
            'name' => 'User',
            'slug' => Str::slug('User'),
            'note' => "User does't have any permission",
            'is_deletable' => true,
            'status' => true,
        ]);

    }
}
