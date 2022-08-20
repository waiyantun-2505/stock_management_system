<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWayoutdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wayoutdetails', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('wayout_id');
            $table->unsignedbigInteger('product_id');
            $table->integer('quantity');
            $table->integer('sale_quantity')->nullable();
            $table->timestamps();

            $table->foreign('wayout_id')
                ->references('id')->on('wayouts')
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
        Schema::dropIfExists('wayoutdetails');
    }
}
