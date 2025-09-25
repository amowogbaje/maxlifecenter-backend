<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UpdateUserBonusPoints extends Command
{
    protected $signature = 'users:update-bonus-points';
    protected $description = 'Update users bonus_point column based on orders table totals';

    public function handle()
    {
        $this->info('Updating user bonus points...');

        // OPTION 1: Bulk single-query update (fastest)
        DB::table('users')->update([
            'bonus_point' => DB::raw('
                (SELECT COALESCE(SUM(orders.bonus_point), 0) 
                 FROM orders 
                 WHERE orders.user_id = users.id)
            ')
        ]);

        // OPTION 2: Chunked loop (safer for complex logic)
        /*
        $this->output->progressStart(User::count());

        User::chunkById(500, function ($users) {
            foreach ($users as $user) {
                $totalBonusPoints = $user->orders()->sum('bonus_point');
                $user->update(['bonus_point' => $totalBonusPoints]);
                $this->output->progressAdvance();
            }
        });

        $this->output->progressFinish();
        */

        $this->info('User bonus points updated successfully.');
        return 0;
    }
}
