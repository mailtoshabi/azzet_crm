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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->nullable(); //TODO: should suffix and prefix in settings.
            $table->foreignId('estimate_id')->constrained()->onDelete('cascade');
            $table->smallInteger('pay_method')->nullable();
            $table->double('round_off')->default(0);
            // $table->double('sub_total')->default(0);
            $table->boolean('is_paid')->comment('1-paid,0-not paid')->default(0);
            $table->double('delivery_charge')->default(0);
            $table->text('reason_hold')->nullable();
            $table->text('reason_cancel')->nullable();
            $table->date('date_confirmed')->nullable();
            $table->date('date_production')->nullable();
            $table->date('date_out_delivery')->nullable();
            $table->date('date_delivered')->nullable();
            $table->date('date_closed')->nullable();
            $table->date('date_onhold')->nullable();
            $table->date('date_cancelled')->nullable();
            $table->smallInteger('status')->default(0)->comment('0:New, 1:confirmed, 2:On Production, 3:Out for delivery, 4:Delivered, 5:Closed, 6:On Hold, 7:Cancelled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
