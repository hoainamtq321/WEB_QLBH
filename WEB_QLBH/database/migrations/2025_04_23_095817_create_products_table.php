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
        Schema::create('products', function (Blueprint $table) {
            $table->increments('product_id');
            $table->string('product_name',100);
            $table->integer('import_price')->default(0);
            $table->integer('sell_price')->default(0);
            $table->integer('quantity_in_stock')->default(0);
            $table->string('img',200)->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('create_by');
            $table->timestamps();

            $table->foreign('create_by') // Định nghĩa khoá id_customer
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
        Schema::dropIfExists('products');
    }
};
