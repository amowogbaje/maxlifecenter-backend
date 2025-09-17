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
        User::factory()->count(30)->create();
        User::factory()->count(20)->create([
            'password' => null
        ]);

        // Example fixed user
        User::create([
            'first_name' => 'Gid',
            'last_name' => 'Watcher',
            'email' => 'gideon@watchlocker.biz',
            'phone' => '08012345678',
            'password'=> Hash::make('4545'),
            'gender' => 'male',
            'bonus_point' => 30,
        ]);
    }
}
