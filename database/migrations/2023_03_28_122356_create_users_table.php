<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable()->unique();
            $table->string('phone')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->text('avatar')->nullable();
            $table->foreignId('branch_id')->nullable()->constrained()->onDelete('cascade');
            $table->boolean('status')->comment('1-Active 0-Inactive')->default(1);
            $table->foreignId('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnDelete();
            $table->rememberToken();
            $table->timestamps();
        });
        User::create(['name' => 'Azzet Admin','email' => 'admin@azzetgroup.com','phone'=>'9809373738','password' => Hash::make('123456'),'email_verified_at'=>now(),'avatar' => 'avatar-1.jpg', 'branch_id'=>1, 'created_at' => now()]);
        User::create(['name' => 'Rameesh','email' => 'rameeshcv@gmail.com','phone'=>'9895310132','password' => Hash::make('123456'),'email_verified_at'=>now(),'avatar' => 'avatar-1.jpg', 'branch_id'=>1,'created_at' => now()]);
        User::create(['name' => 'Shada Mariyam','email' => 'shada@gmail.com','phone'=>'9809373737','password' => Hash::make('123456'),'email_verified_at'=>now(),'avatar' => 'avatar-1.jpg', 'branch_id'=>1,'created_at' => now()]);
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
