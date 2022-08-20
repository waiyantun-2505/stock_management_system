<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWaysaledetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waysaledetails', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->unsignedbigInteger('waysale_id');
            $table->unsignedbigInteger('product_id');
            $table->integer('quantity');
            $table->integer('amount');
            $table->timestamps();

            $table->foreign('waysale_id')
                    ->references('id')->on('waysales')
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
        Schema::dropIfExists('waysaledetails');
    }
}
