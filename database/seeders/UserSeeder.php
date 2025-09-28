<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Example fixed user
        User::create([
            'first_name' => 'Gid',
            'last_name' => 'Watcher',
            'email' => 'hello@watchlocker.biz',
            'phone' => '08012345678',
            'password'=> Hash::make('4545'),
            'gender' => 'male',
            'is_admin' => true,
            'current_reward_id' => 1,
            'bonus_point' => 30,
        ]);
    }
}
