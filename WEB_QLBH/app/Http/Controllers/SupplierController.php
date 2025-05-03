<?php

namespace App\Http\Controllers;

use App\Models\supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = supplier::paginate(10);
        return view('admin.supplier.supplierList',compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'name'=> 'required|string|max:255',
            'phone'=> 'required|string|min:10',
            'address'=> 'nullable|string|max:100'
        ]);
        
        // Tạo nhà cung cấp mới
        supplier::create([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'address' =>$request->input('address'),
        ]);
        return back()->with('success', 'Thêm khách hàng thành công!');
        

        
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
        $supplier = supplier::findOrFail($id);
        return view('admin.supplier.editSupplier',compact('supplier'));
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

        $request->validate([
            'name'=> 'required|string|max:255',
            'phone'=> 'required|string|min:10',
            'address'=> 'nullable|string|max:100'
        ]);

        $supplier = supplier::find($id);

        $supplier->name = $request->name;
        $supplier->phone = $request->phone;
        if ($request->address !== null) {
            $supplier->address = $request->address;
        }
        

        $supplier->save();
        return back()->with('success', 'Khách hàng đã được cập nhật!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!is_numeric($id)) {
            return back()->with('error', 'Thất bại!');
        }
    
        // Tìm bản ghi theo ID
        $supplier = supplier::findOrFail($id);
        if ($supplier) {
            $supplier->delete();
            return back()->with('success', 'Đã xoá nhà cung cấp!');
        }
    
        return back()->with('error', 'Thất bại!');
    }

    function search(Request $request)
    {
        $supplierName = $request->input('name');
        // Tìm sản phẩm theo tên
        if (!$supplierName) {
            $suppliers = supplier::all();
        } else {
            // Tìm khách hàng theo tên
            $suppliers = supplier::where('name', 'LIKE', "%$supplierName%")->get();
        }
        return response()->json($suppliers);
    }
}
