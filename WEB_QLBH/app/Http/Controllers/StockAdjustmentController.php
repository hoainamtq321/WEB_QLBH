<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\stock_adjustment;
use App\Models\stock_adjustment_item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockAdjustmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stock_adjustments = DB::table('stock_adjustments')
            ->join('users','stock_adjustments.create_by','=','users.user_id')
            ->select('stock_adjustments.stock_adjustment_id','stock_adjustments.created_at','stock_adjustments.updated_at','users.full_name','stock_adjustments.status')
            ->paginate(10);
        return view('admin.stock_adjustments.stock_adjustments_list',compact('stock_adjustments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.stock_adjustments.stock_adjustments_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'products.*.product_id' => 'required|exists:products,product_id',
            'products.*.system_inventory' => 'required|integer',
            'products.*.physical_inventory' => 'nullable|integer',
            'products.*.note' => 'nullable|string',
        ]);
        
        DB::beginTransaction();
        try {
            $stock_adjustments = stock_adjustment::create([
                'create_by' => Auth::user()->user_id,
                'status' => 'Đang kiểm kho',
            ]);
            
            
            foreach($request->products as $item)
            {
                $stock_adjustment_items = stock_adjustment_item::create([
                    'stock_adjustment_id' => $stock_adjustments->stock_adjustment_id,
                    'product_id' => $item['product_id'],
                    'system_inventory' => $item['system_inventory'],
                    'physical_inventory' => $item['physical_inventory'],
                    'note' => $item['note'],
                ]);
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Tạo đơn hàng thành công']);
        }catch (\Exception $e) {
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
        $stock_adjustments = DB::table('stock_adjustments')
            ->join('users','stock_adjustments.create_by','=','users.user_id')
            ->select('stock_adjustments.stock_adjustment_id','stock_adjustments.created_at','stock_adjustments.updated_at','users.full_name','stock_adjustments.status')
            ->where('stock_adjustments.stock_adjustment_id',$id)
            ->first();
        $stock_adjustment_items = DB::table('stock_adjustment_items')
            ->join('products','products.product_id','=','stock_adjustment_items.product_id')
            ->select('products.img','products.product_name','stock_adjustment_items.system_inventory','stock_adjustment_items.physical_inventory','stock_adjustment_items.note')
            ->where('stock_adjustment_items.stock_adjustment_id',$id)
            ->get();
        return view('admin.stock_adjustments.stock_adjustments_edit',[
            'stock_adjustments' => $stock_adjustments,
            'stock_adjustment_items' => $stock_adjustment_items,
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
        DB::beginTransaction();
        try {
            // Cập nhật phiếu
            $stock_adjustments = stock_adjustment::find($id);
            $stock_adjustments->status = 'Hoàn thành';
            
            $stock_adjustment_items = stock_adjustment_item::where('stock_adjustment_id',$id)->get();
            foreach($stock_adjustment_items as $item)
            {
                $product = product::find($item['product_id']);
                $product->quantity_in_stock = $item['physical_inventory'];
                $product->save();
            }
            $stock_adjustments->save();
            DB::commit();
            return redirect()->route('admin.stock_adjustments.index');
        }catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.stock_adjustments.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            // Cập nhật phiếu
            $stock_adjustments = stock_adjustment::find($id);
            $stock_adjustments->status = 'Đã huỷ';
            
            $stock_adjustment_items = stock_adjustment_item::where('stock_adjustment_id',$id)->get();
            foreach($stock_adjustment_items as $item)
            {
                $product = product::find($item['product_id']);
                $product->quantity_in_stock = $item['system_inventory'];
                $product->save();
            }
            $stock_adjustments->save();
            DB::commit();
            return redirect()->route('admin.stock_adjustments.index');
        }catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.stock_adjustments.index');
        }
    }
}
