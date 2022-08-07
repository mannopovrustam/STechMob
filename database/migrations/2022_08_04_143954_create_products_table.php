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
            $table->integer('mark_id');
            $table->integer('warehouse_id')->nullable();
            $table->integer('shipment_id')->nullable();
            $table->integer('quantity')->default(0);
            $table->integer('order_count')->default(0);
            $table->text('note')->nullable();
            $table->decimal('price')->default(0);
            $table->decimal('expense')->default(0);
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
