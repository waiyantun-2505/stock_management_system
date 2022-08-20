<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWaystockadddetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waystockadddetails', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('waystockadd_id');
            $table->unsignedbigInteger('product_id');
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('waystockadd_id')
                ->references('id')->on('waystockadds')
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
        Schema::dropIfExists('waystockadddetails');
    }
}
