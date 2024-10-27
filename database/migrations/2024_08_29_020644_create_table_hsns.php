<?php

use App\Http\Utilities\Utility;
use App\Models\Hsn;
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
        Schema::create('hsns', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('tax_slab_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('status')->comment('1-Active 0-Inactive')->default(1);
            $table->timestamps();
        });
        Hsn::create(['name' => '745698', 'tax_slab_id'=>2, 'user_id' => Utility::SUPER_ADMIN_ID,'created_at' => now()]);
        Hsn::create(['name' => '856321', 'tax_slab_id'=>2, 'user_id' => Utility::SUPER_ADMIN_ID,'created_at' => now()]);
        Hsn::create(['name' => '8569874', 'tax_slab_id'=>3, 'user_id' => Utility::SUPER_ADMIN_ID,'created_at' => now()]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hsns');
    }
};
