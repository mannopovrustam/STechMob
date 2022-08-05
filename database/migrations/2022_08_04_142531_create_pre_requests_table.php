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
        Schema::create('pre_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('mark_id')->nullable();
            $table->char('warehouse_form_id')->nullable();
            $table->integer('warehouse_to_id')->nullable();
            $table->integer('count')->nullable();
            $table->dateTime('date')->nullable();
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
        Schema::dropIfExists('pre_requests');
    }
};
