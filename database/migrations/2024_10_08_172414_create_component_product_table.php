<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('component_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('component_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->double('cost')->default(0);
            $table->double('o_cost')->default(0);
            $table->timestamps();
        });

        DB::table('component_product')->insert([
            ['component_id' => 1, 'product_id' => 1, 'cost'=>4.8, 'o_cost'=>8,'created_at' => now()],
            ['component_id' => 2, 'product_id' => 1, 'cost'=>1.25, 'o_cost'=>1,'created_at' => now()],
            ['component_id' => 3, 'product_id' => 1, 'cost'=>2.5, 'o_cost'=>2,'created_at' => now()],
            ['component_id' => 6, 'product_id' => 1, 'cost'=>0.35, 'o_cost'=>0.35,'created_at' => now()],
            ['component_id' => 1, 'product_id' => 2, 'cost'=>8, 'o_cost'=>8,'created_at' => now()],
            ['component_id' => 2, 'product_id' => 2, 'cost'=>1, 'o_cost'=>1,'created_at' => now()],
            ['component_id' => 3, 'product_id' => 2, 'cost'=>2, 'o_cost'=>2,'created_at' => now()],
            ['component_id' => 5, 'product_id' => 2, 'cost'=>2, 'o_cost'=>2,'created_at' => now()],

        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('component_product');
    }
};
