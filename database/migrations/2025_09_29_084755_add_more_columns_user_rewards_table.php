<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('user_rewards', function (Blueprint $table) {
            $table->timestamp('claimed_at')->nullable()->after('status');
            $table->timestamp('approved_at')->nullable()->after('claimed_at');
            $table->timestamp('last_reminder_sent_at')->nullable()->after('approved_at');
            $table->enum('email_status', [
                'pending',    // no email sent yet
                'sent',       // initial notification sent
                'reminded',   // at least one reminder sent
                'claimed',    // user claimed reward
                'approved',   // claim approved
            ])->default('pending')->after('last_reminder_sent_at');
        });
    }

    public function down(): void
    {
        Schema::table('user_rewards', function (Blueprint $table) {
            $table->dropColumn([
                'claimed_at',
                'approved_at',
                'last_reminder_sent_at',
                'email_status',
            ]);
        });
    }
};