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
        Schema::create('analytics', function (Blueprint $table) {
            $table->id();
            $table->json('stats_cards');        // Total Sales, Orders, Sold Products
            $table->json('sales_data');         // Monthly sales chart
            $table->json('category_data');      // Category bar chart
            $table->json('pie_chart_data');     // Pie chart percentages
            $table->json('top_products');       // Top selling products
            $table->json('y_axis_labels')->nullable(); // Y-axis labels for charts
            $table->integer('year')->nullable(); // Current year for charts
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analytics');
    }
};
