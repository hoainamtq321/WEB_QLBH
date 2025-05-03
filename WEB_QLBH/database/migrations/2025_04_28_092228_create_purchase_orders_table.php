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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->increments('purchase_order_id');
            $table->unsignedInteger('supplier_id');
            $table->unsignedInteger('created_by')->nullable();
            $table->enum('status',['Đang giao dịch','Đã thanh toán','Hoàn trả']);
            $table->float('total')->default(0);
            $table->timestamps();

            $table->foreign('created_by') // Định nghĩa khoá id_customer
            ->references('user_id') // Cột created_by tham chiếu đến cột user_id 
            ->on('users') // bản được tham chiếu
            ->onDelete('cascade'); // Nếu bản ghi trong customer xoá thì order tất cả bản ghi trong oder có id_customer cũng xoá theo
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_orders');
    }
};
