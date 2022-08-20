<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditsalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('creditsales', function (Blueprint $table) {
            $table->id();
            $table->string('b_short');
            $table->integer('voucher_no');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('branch_id');
            $table->date('saledate');
            $table->string('credit_method');
            $table->integer('total_amount');
            $table->integer('discount')->nullable();
            $table->integer('bonus')->nullable();
            $table->integer('balance');
            $table->integer('payamount')->nullable();
            $table->string('status');
            $table->timestamps();

            $table->foreign('customer_id')
                    ->references('id')->on('customers')
                    ->onDelete('cascade');

            $table->foreign('branch_id')
                    ->references('id')->on('branches')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('creditsales');
    }
}
