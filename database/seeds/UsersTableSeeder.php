<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Admin User
        $admin = new App\User;
        $admin->name = "Admin User";
        $admin->email = "admin@gmail.com";
        $admin->password = \Illuminate\Support\Facades\Hash::make("secret");        
        $admin->save();

        $admin->assignRole('admin');

        // Owner
        $owner = new App\User;
        $owner->name = "Owner";
        $owner->email = "owner@gmail.com";
        $owner->password = \Illuminate\Support\Facades\Hash::make("secret");
        $owner->save();

        $owner->assignRole('owner');

        // Inspector
        $inspector = new App\User;
        $inspector->name = "Inspector";
        $inspector->email = "inspector@gmail.com";
        $inspector->phone = '1234567890';
        $inspector->password = \Illuminate\Support\Facades\Hash::make("secret");
        $inspector->save();

        $inspector->assignRole('inspector');
    }
}
