<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWaysalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waysales', function (Blueprint $table) {
            
            $table->bigIncrements('id');
            $table->string('b_short');
            $table->integer('voucher_no');
            $table->unsignedbigInteger('wayout_id');
            $table->unsignedBigInteger('customer_id');
            $table->date('waysale_date');
            $table->integer('total_amount');
            $table->integer('discount')->nullable();
            $table->integer('bonus')->nullable();
            $table->integer('balance');
            $table->string('status');
            $table->timestamps();

            $table->foreign('customer_id')
                    ->references('id')->on('customers')
                    ->onDelete('cascade');

            $table->foreign('wayout_id')
                    ->references('id')->on('wayouts')
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
        Schema::dropIfExists('waysales');
    }
}
