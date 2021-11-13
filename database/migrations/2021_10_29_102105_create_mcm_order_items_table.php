<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMcmOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mcm_order_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->integer('quantity_ordered')->default(0);
            $table->string('currency', 3)->nullable();
            $table->decimal('item_price')->default(0);

            $table->timestamps();
        
            $table->bigInteger('product_id')->unsigned()->index()->nullable();
            $table->foreign('product_id')->references('id')->on('mcm_products')->onDelete('set null');

            $table->bigInteger('order_id')->unsigned()->index();
            $table->foreign('order_id')->references('id')->on('mcm_orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mcm_order_items');
    }
}
