<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Admin Suser for the management of the backend
        $admin = new Role();
        $admin->name  = 'admin';
        $admin->guard_name = 'web';
        $admin->save();

        // Owner
        $owner = new Role();
        $owner->name  = 'owner';
        $owner->guard_name = 'web';
        $owner->save();

        // inspector
        $inspector = new Role();
        $inspector->name  = 'inspector';
        $inspector->guard_name = 'web';
        $inspector->save();
    }
}