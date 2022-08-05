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
        Schema::create('currenciables', function (Blueprint $table) {
            $table->id();
            $table->integer('currency_id')->nullable();
            $table->char('currenciable_type')->nullable();
            $table->integer('currenciable_id')->nullable();
            $table->boolean('main');
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
        Schema::dropIfExists('currenciables');
    }
};
