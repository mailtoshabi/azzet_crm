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
        Schema::create('component_estimate_product', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('estimate_product_id')->constrained()->onDelete('cascade');
            $table->foreignId('estimate_product_id');
            $table->foreign('estimate_product_id')->references('id')->on('estimate_product')->cascadeOnDelete();
            $table->foreignId('component_id')->constrained()->onDelete('cascade');
            $table->double('cost')->default(0);
            $table->double('o_cost')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('component_estimate_product');
    }
};
