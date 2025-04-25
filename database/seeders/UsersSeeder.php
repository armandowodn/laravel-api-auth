<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::truncate();
        User::factory()->create([
            'name' => 'admin1',
            'user_name' => 'admin1',
            'email' => 'admin1'.'@gmail.com',
            'password' => Hash::make('password'),
        ]);
        User::factory()->create([
            'name' => 'client1',
            'user_name' => 'client1',
            'email' => 'client1'.'@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }
}
