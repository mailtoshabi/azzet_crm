<?php

use App\Http\Utilities\Utility;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->string('user_type')->default('user'); // Can be 'user' or 'employee'
        });

        Role::create(['name'=>'Administrator','display_name'=>'Administrator', 'user_type'=>'user','created_at' => now(), 'user_id' => Utility::SUPER_ADMIN_ID]);
        Role::create(['name'=>'Manager','display_name'=>'Manager', 'user_type'=>'user','created_at' => now(), 'user_id' => Utility::SUPER_ADMIN_ID]);
        Role::create(['name'=>'HR','display_name'=>'HR Person', 'user_type'=>'user','created_at' => now(), 'user_id' => Utility::SUPER_ADMIN_ID]);
        Role::create(['name'=>'Executive','display_name'=>'Executive', 'user_type'=>'employee','created_at' => now(), 'user_id' => Utility::SUPER_ADMIN_ID]);
        Role::create(['name'=>'OfficeStaff','display_name'=>'Office Staff', 'user_type'=>'employee','created_at' => now(), 'user_id' => Utility::SUPER_ADMIN_ID]);

        Permission::create(['name'=>'All_Permission','display_name'=>'All Permission','created_at' => now(), 'user_id' => Utility::SUPER_ADMIN_ID]);
        Permission::create(['name'=>'User_Managment','display_name'=>'User Managment','created_at' => now(), 'user_id' => Utility::SUPER_ADMIN_ID]);
        Permission::create(['name'=>'Customer_Management','display_name'=>'Customer Management','created_at' => now(), 'user_id' => Utility::SUPER_ADMIN_ID]);
        Permission::create(['name'=>'Category_Management','display_name'=>'Category Management','created_at' => now(), 'user_id' => Utility::SUPER_ADMIN_ID]);
        Permission::create(['name'=>'Product_Management','display_name'=>'Product Management','created_at' => now(), 'user_id' => Utility::SUPER_ADMIN_ID]);
        Permission::create(['name'=>'Enquiry_Management','display_name'=>'Enquiry Management','created_at' => now(), 'user_id' => Utility::SUPER_ADMIN_ID]);
        Permission::create(['name'=>'Estimate_Management','display_name'=>'Estimate Management','created_at' => now(), 'user_id' => Utility::SUPER_ADMIN_ID]);

        DB::table('role_user')->insert([
            ['role_id' => 1, 'user_id' => Utility::SUPER_ADMIN_ID],
            ['role_id' => 2, 'user_id' => 2],
            ['role_id' => 3, 'user_id' => 3],
        ]);

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
     */
    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('user_type');
        });
    }
};
