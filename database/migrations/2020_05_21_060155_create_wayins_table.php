<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWayinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wayins', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('wayout_id');
            $table->unsignedbigInteger('branch_id');
            $table->date('wayin_date');
            $table->timestamps();

            $table->foreign('wayout_id')
                ->references('id')->on('wayouts')
                ->onDelete('cascade');

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
        Schema::dropIfExists('wayins');
    }
}
