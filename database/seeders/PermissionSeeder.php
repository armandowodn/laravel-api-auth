<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = Permission::create(['name' => 'read']);
        $permission = Permission::create(['name' => 'create']);
        $permission = Permission::create(['name' => 'delete']);
        $permission = Permission::create(['name' => 'full-control']);
    }
}
