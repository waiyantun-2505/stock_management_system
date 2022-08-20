<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaledetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saledetails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedbigInteger('sale_id');
            $table->unsignedbigInteger('product_id');
            $table->integer('sale_return')->nullable();
            $table->date('return_date')->nullable();
            $table->integer('quantity');
            $table->integer('amount');
            $table->timestamps();

            $table->foreign('sale_id')
                    ->references('id')->on('sales')
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
        Schema::dropIfExists('saledetails');
    }
}
