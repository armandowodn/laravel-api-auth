<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserPermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_admin = User::where([
            'id' => 1
        ])->first();
        $user_admin->assignRole("admin");
        $user_admin->givePermissionTo('create');
        $user_admin->givePermissionTo('delete');

        $user_common = User::where([
            'id' => 2
        ])->first();
        $user_common->assignRole("common_user");
        $user_common->givePermissionTo('read');
        $user_common->givePermissionTo('create');
    }
}
