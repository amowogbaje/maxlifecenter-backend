<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebhookLogsTable extends Migration
{
    public function up()
    {
        Schema::create('webhook_logs', function (Blueprint $table) {
            $table->id();
            $table->string('topic')->nullable();               // e.g. order.created
            $table->string('resource')->nullable();            // e.g. order
            $table->string('resource_id')->nullable();         // e.g. order id
            $table->string('delivery_id')->nullable();         // optional if provider has it
            $table->string('signature_hash', 64)->nullable();  // sha256 of payload for idempotency check
            $table->json('payload')->nullable();
            $table->string('status')->default('pending');     // pending/processing/processed/failed
            $table->text('response')->nullable();
            $table->unsignedInteger('attempts')->default(0);
            $table->timestamp('retry_at')->nullable();
            $table->timestamps();

            $table->index(['topic']);
            $table->index(['signature_hash']);
            $table->index(['resource', 'resource_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('webhook_logs');
    }
}
