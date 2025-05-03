<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\purchase_order;
use App\Models\purchase_order_item;
use App\Models\supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchase_orders = purchase_order::paginate(10);
        $purchase_orders = DB::table('purchase_orders')
            ->join('suppliers','purchase_orders.supplier_id','=','suppliers.supplier_id')
            ->select('purchase_orders.purchase_order_id','purchase_orders.created_at','purchase_orders.total','purchase_orders.status','suppliers.name')
            ->paginate(10);
        return view('admin.purchase_orders.purchase_orders_list',compact('purchase_orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.purchase_orders.purchase_orders_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|integer|max:255',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,product_id',
            'products.*.product_name' => 'required|string|max:255',
            'products.*.import_price' => 'required|integer|min:0',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            //Tạo bảng purchase_order
            $purchase_orders = purchase_order::create([
                'supplier_id' => $validated['supplier_id'],
                'created_by' => Auth::user()->user_id,
                'status' => "Đang giao dịch",
                'total' => 0
            ]);
            //Cập nhật bảng products
            $products = $validated["products"];

            foreach( $products as $item)
            {
                $purchase_order_item = purchase_order_item::create([
                    'purchase_order_id' => $purchase_orders->purchase_order_id,
                    'product_id' => $item['product_id'],
                    'import_price' => $item['import_price'],
                    'quantity' => $item['quantity'],
                ]);
                $purchase_orders->total += ( $purchase_order_item->import_price*$purchase_order_item->quantity);
                
                $product = product::find($item['product_id']);
                $product['import_price'] = $item['import_price'];
                $product['quantity_in_stock'] = $product['quantity_in_stock'] + $item['quantity'];
                
                $product->save();
            }
            $purchase_orders->save();
            // Cập nhật nợ
            $supplier = supplier::find($validated['supplier_id']);
            $supplier->current_debt += $purchase_orders->total;
            $supplier->save();
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Nhập hàng thành công']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Lỗi nhập hàng']);
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
        return view('admin.purchase_orders.purchase_orders_show', [

            'customer' => $customer,
            'order_items' => $order_items,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $purchase_orders = purchase_order::find($id);
        // Kiểm tra nếu không tìm thấy
        if (!$purchase_orders) {
            return redirect()->back()->with('error', 'Không tìm thấy đơn hàng!');
        }
        // Lấy thông tin nhà cung cấp
        $suppliers = supplier::find($purchase_orders->supplier_id);
        // Kiểm tra nếu không tìm thấy
        if (!$suppliers) {
            return redirect()->back()->with('error', 'Không tìm thấy nhà cung cấp');
        }
        // Lấy thông tin sản phẩm
        $purchase_order_items = DB::table('purchase_order_items')
            ->where('purchase_order_id', $purchase_orders->purchase_order_id)
            ->join('products', 'purchase_order_items.product_id', '=', 'products.product_id') // JOIN bảng products
            ->select(
                'products.img',
                'products.product_name as product_name',
                'purchase_order_items.import_price',
                'purchase_order_items.quantity',
            )
            ->get();
        // Kiểm tra nếu không tìm thấy
        if ($purchase_order_items->isEmpty()) {
            return redirect()->back()->with('error', 'Không tìm thấy sản phẩm');
        }
        
        return view('admin.purchase_orders.purchase_orders_show',[
            'suppliers'=>$suppliers,
            'purchase_order_items'=>$purchase_order_items,
            'purchase_orders'=>$purchase_orders,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Cập nhật phiếu nhập hàng
        $purchase_orders = purchase_order::find($id);
        $purchase_orders->status = "Đã thanh toán";
        $purchase_orders->save();
        
        // Cập nhật nợ với nhà cung cấp
        $suppliers = supplier::find($purchase_orders->supplier_id);
        $suppliers->current_debt -= $purchase_orders->total;
        $suppliers->save();

        return redirect()->route('admin.purchase_orders.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Cập nhật phiếu nhập hàng
        $purchase_orders = purchase_order::find($id);
        $purchase_orders->status = "Hoàn trả";
        $purchase_orders->save();

        // Cập nhật sản phẩm
        $purchase_order_items = purchase_order_item::where('purchase_order_id',$purchase_orders->purchase_order_id)->get();
        foreach($purchase_order_items as $item)
        {
            $product = product::find($item->product_id);
            $product->quantity_in_stock -= $item->quantity;
            $product->save();
        }

        return redirect()->route('admin.purchase_orders.index');
    }
}
