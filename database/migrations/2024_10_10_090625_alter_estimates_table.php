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
        Schema::table('estimates', function (Blueprint $table) {
            $table->foreignId('enquiry_id')->nullable()->after('customer_id')->constrained()->onDelete('cascade');
            // $table->boolean('has_proforma')->comment('1-Yes 0-No')->default(0)->after('enquiry_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('estimates', function (Blueprint $table) {
            $table->dropColumn('enquiry_id');
        });
    }
};
