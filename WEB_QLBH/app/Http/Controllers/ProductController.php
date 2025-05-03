<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function warehouse()
    {
        $products = product::paginate(10);
        return view('admin.products.warehouse', compact('products'));
    }

    public function index()
    {
        $products = product::paginate(10);
        return view('admin.products.productList', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate kiểm  tra  dữ   liệu
        $request->validate([
            'product_name' => 'required|string|max:255',
            'sell_price' => 'nullable|numeric|min:0',
            'import_price' => 'nullable|numeric|min:0',
            'quantity_in_stock' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'img' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'create_by' => 'required|integer|min:0',
        ]);

        // Lấy tên file gốc
        $imageName = "defaulut.jpg";
        if(!empty($request->file('img')))
        {
            $imageName = $request->file('img')->getClientOriginalName();
            $path = $request->file('img')->move(public_path('/assets/img/upload/'), $imageName); // Lưu vào thư mục public
        }

        // Tạo sản phẩm mới
        $product = product::create([
            'product_name' => $request->input('product_name'),
            'sell_price' => $request->input('sell_price') ?? 0,
            'import_price' => $request->input('import_price') ?? 0,
            'quantity_in_stock' =>$request->input('quantity_in_stock') ?? 0,
            'description' => $request->input('description'),
            'img' => $imageName, // Lưu tên file vào database
            'create_by' => $request->input('create_by'),
        ]);
        return back()->with('success', 'Sản phẩm đã được thêm!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.showProduct',compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.editProduct',compact('product'));
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
        
         // validate kiểm  tra  dữ   liệu
         $request->validate([
            'product_name' => 'required|string|max:255',
            'sell_price' => 'nullable|numeric|min:0',
            'import_price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'img' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Tìm sản phẩm
        $product = Product::findOrFail($id);  
        // Cập nhật dữ liệu
        $product->product_name = $request->product_name;
        $product->import_price = $request->import_price;
        $product->sell_price = $request->sell_price;
        $product->description = $request->description;
        // Xử lý ảnh nếu có ảnh mới
    if ($request->hasFile('img')) {
        // Lấy tên ảnh cũ
        $oldImage = $product->img;

        // Xoá ảnh cũ nếu tồn tại
        if ($oldImage) {
            $oldImagePath = public_path('assets/img/upload/' . $oldImage);
            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }
        }

        // Lưu ảnh mới
        $newImageName = time() . '_' . $request->file('img')->getClientOriginalName();
        $request->file('img')->move(public_path('assets/img/upload/'), $newImageName);

        // Gán tên ảnh mới vào database
        $product->img = $newImageName;
    }
 
        $product->save();
        return back()->with('success', 'Sản phẩm đã được cập nhật!');

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
        $product = Product::find($id);
        if ($product) {
            // Xác định đường dẫn ảnh
            $imagePath = public_path('assets/img/upload/' . $product->img);

            // Xóa file nếu tồn tại
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
            $product->delete();
            return back()->with('success', 'Sản phẩm đã được xoá!');
        }
    
        return back()->with('error', 'Thất bại!');
    }

    function search(Request $request)
    {
        $productName = $request->input('name');
        // Tìm sản phẩm theo tên
        if (!$productName) {
            $products = product::all();
        } else {
            // Tìm khách hàng theo tên
            $products = product::where('product_name', 'LIKE', "%$productName%")->get();
        }
        return response()->json($products);
    }
}
