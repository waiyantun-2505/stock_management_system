<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWaycreditsaledetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waycreditsaledetails', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('waycreditsale_id');
            $table->unsignedbigInteger('product_id');
            $table->integer('quantity');
            $table->integer('amount');
            $table->timestamps();

            $table->foreign('waycreditsale_id')
                    ->references('id')->on('waycreditsales')
                    ->onDelete('cascade');

            $table->foreign('product_id')
                    ->references('id')->on('products')
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
        Schema::dropIfExists('waycreditsaledetails');
    }
}
