<?php

namespace App\Http\Controllers;

use App\Models\customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = customer::paginate(10);
        return view('admin.customers.customerList', compact('customers'));
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
            'name' => 'required|string|max:50',
            'phone' => 'required|string|max:12',
            'address'=> 'nullable|string|max:200',
        ]);
        
        // Tạo sản phẩm mới
        $customer = customer::create([
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
        $customer = customer::findOrFail($id);
        return view('admin.customers.editCustomer',compact('customer'));
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
            'name' => 'required|string|max:50',
            'phone' => 'required|string|max:12',
            'address'=> 'nullable|string|max:200',
        ]);

        $customer = customer::findOrFail($id);
        $customer->name = $request->name;
        $customer->phone = $request->phone;
        $customer->address = $request->address;

        $customer->save();
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
        $customer = customer::findOrFail($id);
        if ($customer) {
            $customer->delete();
            return back()->with('success', 'Khách hàng đã được xoá!');
        }
    
        return back()->with('error', 'Thất bại!');
    }

    function search(Request $request)
    {
        $customerName = $request->input('name');
        // Tìm sản phẩm theo tên
        if (!$customerName) {
            $customers = Customer::all();
        } else {
            // Tìm khách hàng theo tên
            $customers = Customer::where('name', 'LIKE', "%$customerName%")->get();
        }
        return response()->json($customers);
    }
}
