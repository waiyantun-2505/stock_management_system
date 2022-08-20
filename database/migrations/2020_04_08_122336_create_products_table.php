<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('code_no');
            $table->string('name');
            $table->unsignedBigInteger('subcategory_id');
            $table->float('order_price');
            $table->integer('sale_price');
            $table->timestamps();

           

            $table->foreign('subcategory_id')
                    ->references('id')->on('subcategories')
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
        Schema::dropIfExists('products');
    }
}
