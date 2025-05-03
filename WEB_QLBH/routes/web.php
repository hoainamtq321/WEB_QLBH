<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StockAdjustmentController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



// Đăng nhập
// Route đăng nhập
Route::get('login', [LoginController::class, 'showForm'])->name('formLogin');
Route::post('login', [LoginController::class, 'login'])->name('login');

// Nhóm route 'admin' với middleware 'auth' để đảm bảo chỉ người đã đăng nhập mới truy cập được
Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function(){

        // Chung ai cũng có thể dùng
        Route::get('/',[ManagerController::class,'index']);
        Route::get('/products/search', [ProductController::class,'search'])->name('products.search');

        Route::get('/report/sale',[ReportController::class,'sale'])->name('report.sale');


        // Chỉ cho ai có quyền manager,sales_agent
        Route::middleware(['check.role:sales_agent,manager'])->group(function () {
            #Đơn hàng
            Route::resource('orders', OrderController::class);

            #Khách hàng
            Route::get('customers/search',[CustomerController::class,'search'])->name('customers.search');
            Route::resource('/customers', CustomerController::class);
        });
    

        // Chỉ cho ai có quyền manager,warehouse_worker
        Route::middleware(['check.role:warehouse_worker,manager'])->group(function () {
            #Sản phẩm
            Route::get('products/warehouse', [ProductController::class,'warehouse'])->name('products.warehouse');
            Route::resource('products', ProductController::class);
            #Nhập hàng
            Route::resource('purchase_orders', PurchaseOrderController::class);
            #Kiểm hàng
            Route::resource('stock_adjustments', StockAdjustmentController::class);
            #Nhà cung cấp
            Route::get('suppliers/search',[SupplierController::class,'search'])->name('suppliers.search');
            Route::resource('suppliers', SupplierController::class);
            
        });

    });



});



/*Gộp chung controller 
            
            Route::controller(AdminController::class)->group(function () {
                Route::get('/', 'index')->name('admin.dashboard');
                Route::get('/products', 'listProducts')->name('admin.products');
                Route::get('/create-product', 'createProduct')->name('admin.createProduct');
                Route::get('/customers', 'listCustomers')->name('admin.customers');
                Route::get('/orders', 'listOrders')->name('admin.orders');
            });
            */
