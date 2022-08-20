<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWayindetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wayindetails', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('wayin_id');
            $table->unsignedbigInteger('product_id');
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('wayin_id')
                ->references('id')->on('wayins')
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
        Schema::dropIfExists('wayindetails');
    }
}
