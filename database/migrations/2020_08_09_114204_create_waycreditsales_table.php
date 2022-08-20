<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWaycreditsalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waycreditsales', function (Blueprint $table) {
            $table->id();
            $table->string('b_short');
            $table->unsignedbigInteger('wayout_id');
            $table->integer('voucher_no');
            $table->unsignedBigInteger('customer_id');
            $table->date('waysale_date');
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

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('waycreditsales');
    }
}
