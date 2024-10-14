<?php

use App\Http\Utilities\Utility;
use App\Models\Component;
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
        Schema::create('components', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('cost')->default(0);
            $table->boolean('status')->comment('1-Active 0-Inactive')->default(1);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
        Component::create(['name' => 'Paper', 'cost' => 8, 'user_id' => Utility::ADMIN_ID,'created_at' => now()]);
        Component::create(['name' => 'Handle', 'cost' => 1, 'user_id' => Utility::ADMIN_ID,'created_at' => now()]);
        Component::create(['name' => 'Print', 'cost' => 2, 'user_id' => Utility::ADMIN_ID,'created_at' => now()]);
        Component::create(['name' => 'Lamination', 'cost' => 1, 'user_id' => Utility::ADMIN_ID,'created_at' => now()]);
        Component::create(['name' => 'Job', 'cost' => 2, 'user_id' => Utility::ADMIN_ID,'created_at' => now()]);
        Component::create(['name' => 'Transport', 'cost' => .35, 'user_id' => Utility::ADMIN_ID,'created_at' => now()]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('components');
    }
};
