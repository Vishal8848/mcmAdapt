<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMcmOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mcm_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_no');
            $table->date('order_date');
            $table->integer('order_status')->nullable();
            $table->string('currency', 3)->nullable();
            $table->decimal('order_total')->nullable();
            //On a given channel, order_no shd be unique
            $table->unique(['order_no']);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mcm_orders');
    }
}
