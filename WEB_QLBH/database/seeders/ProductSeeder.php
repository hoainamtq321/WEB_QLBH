<?php

namespace Database\Seeders;

use App\Models\product;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            ['product_name' => 'Đèn tường 6 tia trắng', 'sell_price' => '100000', 'img' => '1745471535_105.jpg','quantity_in_stock'=>5],
            ['product_name' => 'Đèn tường 6 tiaa đen', 'sell_price' => '50000', 'img' => '104.jpg','quantity_in_stock'=>8],
            ['product_name' => 'Quạt trần', 'sell_price' => '10000', 'img' => '11.png','quantity_in_stock'=>7],
            ['product_name' => 'Đèn downlight 12W', 'sell_price' => '20000', 'img' => 'amtran.jpg','quantity_in_stock'=>4],
        ];

        foreach ($products as $p) {
            product::create([
                'product_name' => $p['product_name'],
                'sell_price' => $p['sell_price'],
                'img' => $p['img'],
                'quantity_in_stock' => $p['quantity_in_stock'],
                'create_by'=> 1,
                'created_at' => Carbon::now(), // Thêm ngày tạo hiện tại
            ]);
        }
    }
}
