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
        Schema::create('stock_adjustments', function (Blueprint $table) {
            $table->increments('stock_adjustment_id');
            $table->unsignedInteger('create_by');
            $table->unsignedInteger('completed_by')->nullable();
            $table->enum('status', ['Đang kiểm kho', 'Hoàn thành', 'Đã huỷ'])->default('Đang kiểm kho');
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
        Schema::dropIfExists('stock_adjustments');
    }
};
