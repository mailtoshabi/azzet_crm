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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('trade_name')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('phone')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('address3')->nullable();
            $table->string('city')->nullable();
            $table->foreignId('district_id')->nullable();
            $table->foreign('district_id')->references('id')->on('districts')->cascadeOnDelete();
            $table->foreignId('state_id')->nullable();
            $table->foreign('state_id')->references('id')->on('states')->cascadeOnDelete();
            $table->string('postal_code')->nullable();
            $table->text('image')->nullable();
            $table->string('website')->nullable(); // Customer website

            $table->string('gstin')->nullable(); // Optional GSTIN (Goods and Services Tax Identification Number)
            $table->string('cin')->nullable(); // Optional CIN (Corporate Identification Number)
            $table->string('pan')->nullable(); // Optional PAN (Permanent Account Number)
            $table->foreignId('bank_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('account_name')->nullable(); // Account name
            $table->string('account_number')->nullable(); // Account number
            $table->string('bank_branch')->nullable(); // Branch name
            $table->string('ifsc')->nullable(); // IFSC (Indian Financial System Code)

            $table->foreignId('branch_id')->nullable()->constrained()->onDelete('cascade');
            $table->boolean('status')->comment('1-Active 0-Inactive')->default(1);
            $table->boolean('is_approved')->comment('1-Approved 0-Unapporved')->default(0);
            $table->foreignId('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
