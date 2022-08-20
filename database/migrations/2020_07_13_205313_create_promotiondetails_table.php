<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotiondetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotiondetails', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_no')->references('voucher_no')->on(['sales','creditsales'])->onDelete('cascade');
            $table->unsignedbiginteger('promotion_id')->references('id')->on('promotions')->onDelete('cascade');
            $table->unsignedbiginteger('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->integer('quantity');
            $table->timestamps();

            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promotiondetails');
    }
}
