<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Reward;

class RewardSeeder extends Seeder
{
    public function run(): void
    {
        $rewards = [
            [
                'title' => 'Eleniyan',
                'code' => 'PN00001',
                'description' => 'Enjoy 10% off upto #30,000.',
                'required_points' => 0,
                'required_purchases' => 1,
                'priority' => 1,
                'img_src' => 'images/rewards/eleniyan.png',
                'reward_benefit' => 'Cap',
            ],
            [
                'title' => 'Oloye',
                'code' => 'PN00002',
                'description' => 'Enjoy 15% off upto #50,000.',
                'required_points' => 500,
                'required_purchases' => 3,
                'priority' => 2,
                'img_src' => 'images/rewards/oloye.png',
                'reward_benefit' => 'Afro centric beads',
            ],
            [
                'title' => 'Balogun',
                'code' => 'PN00003',
                'description' => 'Enjoy 20% off upto #150,000.',
                'required_points' => 1500,
                'required_purchases' => 7,
                'priority' => 3,
                'img_src' => 'images/rewards/balogun.png',
                'reward_benefit' => 'Kaftan',
            ],
            [
                'title' => 'Kabiyesi',
                'code' => 'PN00004',
                'description' => 'Enjoy 30% off upto #300,000.',
                'required_points' => 3000,
                'required_purchases' => 14,
                'priority' => 4,
                'img_src' => 'images/rewards/kabiyesi.png',
                'reward_benefit' => 'Gift box',
            ],
        ];

        foreach ($rewards as $reward) {
            Reward::updateOrCreate(
                ['priority' => $reward['priority']],
                $reward
            );
        }
    }
}
