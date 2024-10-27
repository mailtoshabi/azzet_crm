<?php

use App\Http\Utilities\Utility;
use App\Models\Product;
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
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',255);
            $table->string('image')->nullable();
            $table->text('images')->nullable();
            $table->double('profit')->default(0);
            $table->foreignId('uom_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('hsn_id')->nullable()->constrained()->onDelete('cascade');
            $table->boolean('status')->comment('1-Active 0-Inactive')->default(1);
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->boolean('is_approved')->comment('1-Approved 0-Unapporved')->default(0);
            $table->foreignId('branch_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->timestamps();
        });
        Product::create(['name' => 'Carry Bag', 'profit'=>3,'uom_id'=>1,'hsn_id'=>1, 'category_id'=>1, 'is_approved'=>1, 'user_id' => Utility::SUPER_ADMIN_ID, 'branch_id'=>1,'created_at' => now()]);
        Product::create(['name' => 'Signage', 'profit'=>2.5,'uom_id'=>1,'hsn_id'=>2, 'category_id'=>1, 'is_approved'=>1, 'user_id' => Utility::SUPER_ADMIN_ID, 'branch_id'=>1,'created_at' => now()]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
