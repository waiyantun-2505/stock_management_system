<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedBigInteger('city_id');
            $table->text('phone');
            $table->text('way')->nullable();
            $table->unsignedBigInteger('marketer_id')->nullable();
            $table->text('delivery_gate')->nullable();
            $table->text('delivery_phone')->nullable();
            $table->text('address');
            $table->timestamps();

            $table->foreign('city_id')
                    ->references('id')->on('cities')
                    ->onDelete('cascade');

            $table->foreign('marketer_id')
                    ->references('id')->on('marketers')
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
        Schema::dropIfExists('customers');
    }
}
