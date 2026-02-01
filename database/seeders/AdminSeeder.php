<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Example fixed user
        Admin::create([
            'first_name' => 'Tope',
            'last_name' => 'Olajubu',
            'email' => 'hello@maxlifecenter.org',
            'phone' => '08012345678',
            'password'=> Hash::make('password'),
            'gender' => 'male',
        ]);
    }
}
