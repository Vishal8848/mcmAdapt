<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMcmProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mcm_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->string('name')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            //Price
            $table->string('currency', 3)->nullable();
            $table->decimal('mrp')->default(0);
            $table->decimal('price')->default(0);

            $table->timestamps();

            $table->unique(['code']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mcm_products');
    }
}
