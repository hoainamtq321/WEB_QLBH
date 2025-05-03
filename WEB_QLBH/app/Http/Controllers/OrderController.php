<?php

namespace App\Http\Controllers;

use App\Models\customer;
use App\Models\order;
use App\Models\order_item;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = DB::table('orders')
            ->join('customers', 'orders.customer_id', '=', 'customers.customer_id')
            ->select('orders.order_id','orders.status','orders.created_at', 'orders.total', 'customers.name as customer_name')
            ->paginate(10);
        return view('admin.orders.orderList', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.orders.orderCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    # Tạo đơn
    public function store(Request $request)
    {

        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,customer_id',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,product_id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);
        DB::beginTransaction();
        try {
        // Kiểm tra tồn kho...
            $products = $validated["products"];

            foreach ($products as $item) {
                $product = Product::find($item['product_id']);

                if ($product->quantity_in_stock < $item['quantity']) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => "Sản phẩm '{$product->product_name}' không đủ hàng (còn {$product->quantity_in_stock})"
                    ], 400);
                }
            }

            $user_id = Auth::user()->user_id;
        // Tạo order...
            $order = Order::create([
                'customer_id' => $validated['customer_id'],
                'created_by' => $user_id,
                'total' => 0,
                'status' => 'Đang chờ'
            ]);
            $total = 0;
        // Trừ kho...
            foreach ($products as $item) {
                $product = Product::find($item['product_id']);
                $quantity = $item['quantity'];
                $sell_price = $product->sell_price; 
                $total += $sell_price*$quantity;

                $order_item =  order_item::create([
                    'order_id' => $order->order_id,
                    'product_id' => $product->product_id,
                    'quantity' => $quantity,
                    'price' => $sell_price,
                ]);   
                
                // giảm giá trị quantity trrong bảng product
                $product->decrement('quantity_in_stock', $quantity);
            }
            
        // Cập nhật tổng tiền
            $order->update(['total' => $total]);

        // Cập nhật khách hàng
            $customer = customer::find($validated['customer_id']);
            
            $customer->total_spent += $total;
            $customer->total_orders += 1;
            $customer->save();
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Tạo đơn hàng thành công']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Lỗi tạo đơn hàng']);
        }

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
            // Lấy đơn hàng theo id
        $order = DB::table('orders')->where('order_id', $id)->first();

        // Kiểm tra nếu không tìm thấy đơn hàng
        if (!$order) {
            return redirect()->back()->with('error', 'Không tìm thấy đơn hàng!');
        }

        // Lấy thông tin khách hàng từ bảng customers
        $customer = DB::table('customers')->where('customer_id', $order->customer_id)->first();

        // Truy vấn thông tin chi tiết đơn hàng từ bảng order_details kết hợp với bảng products
        $order_items = DB::table('order_items')
            ->where('order_items.order_id', $id) // Lọc theo order_id
            ->join('products', 'order_items.product_id', '=', 'products.product_id') // JOIN bảng products
            ->join('orders', 'orders.order_id', '=','order_items.order_id' )
            ->select(
                'order_items.order_id',
                'orders.status',
                'products.img',
                'products.product_name as product_name',
                'products.sell_price',
                'order_items.quantity',
            )
            ->get();

        // Truyền dữ liệu vào view orderEdit
        return view('admin.orders.orderEdit', [

            'customer' => $customer,
            'order_items' => $order_items,
        ]);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        
        $order = order::find($id);
        if($order->status == 'Đang chờ')
        {
            $order->update(['status' => 'Hoàn thành']);
        }
        return redirect()->route('admin.orders.index');
    }

    public function destroy($id)
    {
        if (!is_numeric($id)) {
            abort(400, 'ID không hợp lệ');
        }

        $order = order::find($id);# lấy dữ liệu trong bảng order
        if($order->order_id !== 3)
        {
            // Lấy thông tin khách hàng từ bảng customers
            $customer = customer::find($order->customer_id);
            # Cập nhật thông tin sau khi huỷ đơn
            $customer->total_orders = $customer->total_orders - 1;
            $customer->total_spent = $customer->total_spent - $order->total;
            $customer->save();


            // Lấy thông tin chi tiết đơn hàng
            $order_items = Order_item::where("order_id",$order->order_id)->get();
            foreach($order_items as $item)
            {
                // Cập nhật số lượng sản phẩm
                $product = product::find($item->product_id);
                $product->quantity_in_stock = $product->quanquantity_in_stocktity + $item->quantity;
                $product->save();
            }
            
        }
        $order->update(['status' => 'Đã huỷ']); # cập nhật order
        // DB::table('orders')->where('id', $id)->update(['status' => 3]); # Cập nhật nhanh
        return redirect()->route('admin.orders.index');

    }
}

/*
// Kiểm tra nếu trong quá trình truy xuất sẩy ra lỗi sẽ reset
DB::beginTransaction();
    try {
       DB::commit();
            return response()->json(['success' => true, 'message' => 'Tạo đơn hàng thành công']);
    } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Lỗi tạo đơn hàng']);
    }
*/