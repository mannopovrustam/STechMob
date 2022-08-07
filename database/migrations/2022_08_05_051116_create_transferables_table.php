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
            $table->string('type')->nullable();
            $table->string('date')->useCurrent();
            $table->string('note')->nullable();
            $table->string('warehouse_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('transferable_type');
            $table->integer('transferable_id');
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
        Schema::dropIfExists('transferables');
    }
};
