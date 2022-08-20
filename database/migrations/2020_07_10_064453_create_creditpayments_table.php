<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditpaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('creditpayments', function (Blueprint $table) {
            $table->id();
            $table->integer('voucher_no');
            $table->unsignedbiginteger('creditsale_id');
            $table->date('date');
            $table->integer('amount');
            $table->timestamps();

            $table->foreign('creditsale_id')
                    ->references('id')->on('creditsales')
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
        Schema::dropIfExists('creditpayments');
    }
}
