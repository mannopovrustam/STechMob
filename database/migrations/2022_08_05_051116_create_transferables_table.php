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
        Schema::create('transferables', function (Blueprint $table) {
            $table->id();
            $table->char('type')->nullable();
            $table->char('date')->nullable();
            $table->char('note')->nullable();
            $table->char('warehouse_id')->nullable();
            $table->char('transferable_type')->nullable();
            $table->integer('transferable_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('transferables');
    }
};
