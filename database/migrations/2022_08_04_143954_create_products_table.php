<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('mark_id')->nullable();
            $table->integer('warehouse_id')->nullable();
            $table->integer('shipment_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('order_count')->nullable();
            $table->text('note')->nullable();
            $table->double('price')->nullable();
            $table->double('expense')->nullable();
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
        Schema::dropIfExists('products');
    }
};
