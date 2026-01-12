<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1️⃣ Fix existing invalid / NULL bodies
        DB::statement("
            UPDATE blogs
            SET body = JSON_OBJECT(
                'time', UNIX_TIMESTAMP(),
                'blocks', JSON_ARRAY(),
                'version', '2.28.2'
            )
            WHERE body IS NULL
               OR JSON_VALID(body) = 0
        ");

        // 2️⃣ Change column type to JSON
        Schema::table('blogs', function (Blueprint $table) {
            $table->json('body')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->text('body')->change();
        });
    }
};
