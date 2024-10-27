<?php

use App\Http\Utilities\Utility;
use App\Models\Uom;
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
        Schema::create('uoms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('status')->comment('1-Active 0-Inactive')->default(1);
            $table->timestamps();
        });
        Uom::create(['name' => 'Nos', 'user_id' => Utility::SUPER_ADMIN_ID,'created_at' => now()]);
        Uom::create(['name' => 'Packet', 'user_id' => Utility::SUPER_ADMIN_ID,'created_at' => now()]);
        Uom::create(['name' => 'Pairs', 'user_id' => Utility::SUPER_ADMIN_ID,'created_at' => now()]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uoms');
    }
};
