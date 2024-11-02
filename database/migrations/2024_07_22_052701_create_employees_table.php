<?php

use App\Models\Employee;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone')->nullable()->unique();
            $table->string('building_no')->nullable();
            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->foreignId('district_id')->nullable();
            $table->foreign('district_id')->references('id')->on('districts')->cascadeOnDelete();
            $table->foreignId('state_id')->nullable();
            $table->foreign('state_id')->references('id')->on('states')->cascadeOnDelete();
            $table->text('avatar')->nullable();
            $table->boolean('status')->comment('1-Active 0-Inactive')->default(1);
            $table->foreignId('branch_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->rememberToken();
            $table->timestamps();
        });
        Employee::create(['name' => 'Azzet Employee','email' => 'shabeer.exe@azzetgroup.com','phone'=>'9809373736','password' => Hash::make('123456'),'email_verified_at'=>now(),'avatar' => 'avatar-1.jpg', 'branch_id'=>1,'created_at' => now()]);
        Employee::create(['name' => 'Foco Employee','email' => 'foco.exe@gmail.com','phone'=>'9847555222','password' => Hash::make('123456'),'email_verified_at'=>now(),'avatar' => 'avatar-1.jpg', 'branch_id'=>2,'created_at' => now()]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
