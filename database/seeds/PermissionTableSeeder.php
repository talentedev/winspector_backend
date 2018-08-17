<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Admin Suser for the management of the backend
        $admin = new Permission();
        $admin->name  = 'admin';
        $admin->guard_name = 'web';
        $admin->save();

        // Owner
        $owner = new Permission();
        $owner->name  = 'owner';
        $owner->guard_name = 'api';
        $owner->save();

        // inspector
        $inspector = new Permission();
        $inspector->name  = 'inspector';
        $inspector->guard_name = 'api';
        $inspector->save();
    }
}
