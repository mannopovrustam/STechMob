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
        Schema::create('money_invoices', function (Blueprint $table) {
            $table->id();
            $table->char('name')->nullable();
            $table->integer('currency_id')->nullable();
            $table->double('money_sys')->nullable();
            $table->double('money_get')->nullable();
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
        Schema::dropIfExists('money_invoices');
    }
};
