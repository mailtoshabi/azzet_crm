<?php

use App\Http\Utilities\Utility;
use App\Models\TaxSlab;
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
        Schema::create('tax_slabs', function (Blueprint $table) {
            $table->id();
            $table->double('name_tax');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('status')->comment('1-Active 0-Inactive')->default(1);
            $table->timestamps();
        });
        TaxSlab::create(['name_tax' => '5', 'user_id' => Utility::SUPER_ADMIN_ID,'created_at' => now()]);
        TaxSlab::create(['name_tax' => '12', 'user_id' => Utility::SUPER_ADMIN_ID,'created_at' => now()]);
        TaxSlab::create(['name_tax' => '18', 'user_id' => Utility::SUPER_ADMIN_ID,'created_at' => now()]);
        TaxSlab::create(['name_tax' => '28', 'user_id' => Utility::SUPER_ADMIN_ID,'created_at' => now()]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tax_slabs');
    }
};
