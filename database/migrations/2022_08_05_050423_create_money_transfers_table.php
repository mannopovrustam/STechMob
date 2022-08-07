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
        Schema::create('money_transfers', function (Blueprint $table) {
            $table->id();
            $table->integer('money_invoice_id');
            $table->foreignId('currency_id')->constrained()
                ->onUpdate('cascade')->onDelete('cascade');
            $table->double('money_sys')->default(0);
            $table->double('money_get')->default(0);
            $table->boolean('main')->default(false);
            $table->tinyInteger('status')->default(\App\Models\Transferable::STATUS['waiting']);
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
        Schema::dropIfExists('money_transfers');
    }
};
