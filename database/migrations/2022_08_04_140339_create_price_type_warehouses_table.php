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
        Schema::create('price_type_warehouses', function (Blueprint $table) {
            $table->id();
            $table->integer('pricetype_id')->nullable();
            $table->integer('warehouse_id')->nullable();
            $table->integer('currency_id')->nullable();
            $table->integer('mark_id')->nullable();
            $table->double('bonus')->nullable();
            $table->double('price')->nullable();
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
        Schema::dropIfExists('price_type_warehouses');
    }
};
