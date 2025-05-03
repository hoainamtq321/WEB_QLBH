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
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('order_id');
            $table->unsignedInteger('customer_id'); // Khớp với kiểu `increments()` ở bảng customers
            $table->unsignedInteger('created_by');
            $table->float('total');
            $table->enum('status', ['Đang chờ', 'Hoàn thành', 'Đã huỷ'])->default('Đang chờ');

            $table->foreign('customer_id') // Định nghĩa khoá id_customer
                ->references('customer_id') // Cột id_customer tham chiếu đến cột id 
                ->on('customers') // bản được tham chiếu
                ->onDelete('cascade'); // Nếu bản ghi trong customer xoá thì order tất cả bản ghi trong oder có id_customer cũng xoá theo
            
            $table->foreign('created_by') // Định nghĩa khoá id_customer
                ->references('user_id') // Cột id_customer tham chiếu đến cột id 
                ->on('users') // bản được tham chiếu
                ->onDelete('cascade'); // Nếu bản ghi trong customer xoá thì order tất cả bản ghi trong oder có id_customer cũng xoá theo
            
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
        Schema::dropIfExists('orders');
    }
};
