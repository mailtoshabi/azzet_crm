<?php

use App\Http\Utilities\Utility;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class LaravelEntrustSetupTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema to create roles table
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->timestamps();
        });
        Role::create(['name'=>'Administrator','display_name'=>'Administrator','created_at' => now(), 'user_id' => Utility::SUPER_ADMIN_ID]);
        Role::create(['name'=>'Manager','display_name'=>'Manager','created_at' => now(), 'user_id' => Utility::SUPER_ADMIN_ID]);
        Role::create(['name'=>'HR','display_name'=>'HR Person','created_at' => now(), 'user_id' => Utility::SUPER_ADMIN_ID]);

        // Schema to create permissions table
        Schema::create('permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->timestamps();
        });
        Permission::create(['name'=>'All_Permission','display_name'=>'All Permission','created_at' => now(), 'user_id' => Utility::SUPER_ADMIN_ID]);
        Permission::create(['name'=>'User_Managment','display_name'=>'User Managment','created_at' => now(), 'user_id' => Utility::SUPER_ADMIN_ID]);
        Permission::create(['name'=>'Customer_Management','display_name'=>'Customer Management','created_at' => now(), 'user_id' => Utility::SUPER_ADMIN_ID]);
        Permission::create(['name'=>'Category_Management','display_name'=>'Category Management','created_at' => now(), 'user_id' => Utility::SUPER_ADMIN_ID]);
        Permission::create(['name'=>'Product_Management','display_name'=>'Product Management','created_at' => now(), 'user_id' => Utility::SUPER_ADMIN_ID]);
        Permission::create(['name'=>'Enquiry_Management','display_name'=>'Enquiry Management','created_at' => now(), 'user_id' => Utility::SUPER_ADMIN_ID]);
        Permission::create(['name'=>'Estimate_Management','display_name'=>'Estimate Management','created_at' => now(), 'user_id' => Utility::SUPER_ADMIN_ID]);

        // Schema to create role_users table
        Schema::create('role_user', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('user_id');

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('role_id')->references('id')->on('roles')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['user_id', 'role_id']);
        });
        DB::table('role_user')->insert([
            ['role_id' => 1, 'user_id' => Utility::SUPER_ADMIN_ID],
            ['role_id' => 2, 'user_id' => 2],
            ['role_id' => 3, 'user_id' => 3],
        ]);

        // Schema to create permission_role table
        Schema::create('permission_role', function (Blueprint $table) {
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('role_id');

            $table->foreign('permission_id')->references('id')->on('permissions')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['permission_id', 'role_id']);
        });
        DB::table('permission_role')->insert([
            ['permission_id' => 1, 'role_id' => 1],
            ['permission_id' => 3, 'role_id' => 2],
            ['permission_id' => 4, 'role_id' => 2],
            ['permission_id' => 5, 'role_id' => 2],
            ['permission_id' => 6, 'role_id' => 2],
            ['permission_id' => 7, 'role_id' => 2],
            ['permission_id' => 6, 'role_id' => 3],
            ['permission_id' => 7, 'role_id' => 3],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
    }
}
