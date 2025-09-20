<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // WooCommerce fields
            $table->bigInteger('woo_id')->nullable()->index()->after('id');
            $table->string('company')->nullable()->after('phone');
            $table->string('address_1')->nullable()->after('company');
            $table->string('address_2')->nullable()->after('address_1');
            $table->string('city')->nullable()->after('address_2');
            $table->string('state')->nullable()->after('city');
            $table->string('postcode')->nullable()->after('state');
            $table->string('country')->nullable()->after('postcode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'woo_id',
                'company',
                'address_1',
                'address_2',
                'city',
                'state',
                'postcode',
                'country',
            ]);
        });
    }
};
