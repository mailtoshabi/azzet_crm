<?php

use App\Http\Utilities\Utility;
use App\Models\Category;
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
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',255);
            $table->string('image')->nullable();
            $table->boolean('status')->comment('1-Active 0-Inactive')->default(1);
            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->timestamps();
        });
        Category::create(['name' => 'Carry Bag', 'user_id' => Utility::SUPER_ADMIN_ID,'created_at' => now()]);
        Category::create(['name' => 'Signage', 'user_id' => Utility::SUPER_ADMIN_ID,'created_at' => now()]);
        Category::create(['name' => 'Hospital Folders', 'user_id' => Utility::SUPER_ADMIN_ID,'created_at' => now()]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
