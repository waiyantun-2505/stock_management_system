<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWayoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wayouts', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('branch_id');
            $table->date('wayout_date');
            $table->text('way_cities');
            $table->text('wayin_status')->nullable();
            $table->text('status')->nullable();
            $table->timestamps();

            $table->foreign('branch_id')
                    ->references('id')->on('branches')
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
        Schema::dropIfExists('wayouts');
    }
}
