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
            $table->foreignId('pricetype_id')->constrained('price_types');
            $table->integer('warehouse_id')->nullable();
            $table->integer('currency_id')->default(1);
            $table->integer('mark_id')->nullable();
            $table->decimal('bonus')->nullable();
            $table->decimal('price')->nullable();
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
