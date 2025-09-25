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
                'description' => 'Tier 1 - Entry low-rank chief. Entry point: Purchase 1 item.',
                'required_points' => 0,
                'required_purchases' => 1,
                'priority' => 1,
                'img_src' => 'images/rewards/eleniyan.png',
                'reward_benefit' => 'Cap',
            ],
            [
                'title' => 'Oloye',
                'description' => 'Tier 2 - Intermediate high-rank chief. Entry point: Purchase 3 items OR 500 points (₦500,000 spend).',
                'required_points' => 500,
                'required_purchases' => 3,
                'priority' => 2,
                'img_src' => 'images/rewards/oloye.png',
                'reward_benefit' => 'Afro centric beads',
            ],
            [
                'title' => 'Balogun',
                'description' => 'Tier 3 - Advanced high-rank chief. Entry point: Purchase 7 items AND 1500 points (₦1.5m spend).',
                'required_points' => 1500,
                'required_purchases' => 7,
                'priority' => 3,
                'img_src' => 'images/rewards/balogun.png',
                'reward_benefit' => 'Kaftan',
            ],
            [
                'title' => 'Kabiyesi',
                'description' => 'Tier 4 - Elite: King. Entry point: Purchase 14 items AND 3000 points (₦3m spend).',
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
