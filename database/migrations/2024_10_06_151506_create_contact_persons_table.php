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
        Schema::create('contact_persons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable(); // Email of the contact person
            $table->string('phone')->nullable(); // Phone number of the contact person
            $table->foreignId('customer_id')->constrained()->onDelete('cascade'); // Foreign key referencing customers table
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_persons');
    }
};
