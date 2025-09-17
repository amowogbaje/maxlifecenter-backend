<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\WebhookLog;
use App\Jobs\ProcessWebhookJob;

class ProcessPendingWebhooks extends Command
{
    protected $signature = 'webhooks:process';
    protected $description = 'Process all pending WooCommerce webhooks';

    public function handle()
    {
        $pendingLogs = WebhookLog::where('status', 'pending')->limit(20)->get();

        if ($pendingLogs->isEmpty()) {
            $this->info('No pending webhooks.');
            return Command::SUCCESS;
        }

        foreach ($pendingLogs as $log) {
            $this->info("Processing webhook #{$log->id} ({$log->topic})...");

            // Call job logic directly
            (new ProcessWebhookJob($log->id))->handle();
        }

        return Command::SUCCESS;
    }
}
