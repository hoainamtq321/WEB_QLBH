@extends('admin.master')
@section('content')
<div class="row">
    <div class="col-md-12">

        <div class="card">
          <div class="card-header">
            <h1>Thông tin sản phẩm</h1>
          </div>
          <div class="card-body">
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group form-group-default">
                    <label>Tên sản phẩm</label>
                    <p>{{$product->product_name}}</p>
                  </div>
                </div>
                
                <div class="col-md-4 pe-0">
                  <div class="form-group form-group-default">
                    <label>Giá bán</label>
                    <p>{{$product->sell_price}}</p>
                  </div>
                </div>
                <div class="col-md-4 pe-0">
                  <div class="form-group form-group-default">
                    <label>Giá nhập</label>
                    <p>{{$product->import_price}}</p>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group form-group-default">
                    <label>Số lượng</label>
                    <p>{{$product->quantity_in_stock}}</p>
                  </div>
                </div>

                <div class="col-md-6">
                    <label class="text-center col-md-12">Ảnh sản phẩm</label>
                    <div class="">
                        <div class="col-md-12 form-group form-group-default d-flex  justify-content-center">
                            <div class="frame">
                                <img  id="img" class="frame-avatar" src="/assets/img/upload/{{$product->img}}">
                            </div>
                        </div>
                    </div>
                </div>
        
                <div class="col-md-6">
                  <div class="form-group form-group-default">
                    <label>Mô tả</label>
                    <textarea class="w-100" name="" id="" cols="" rows="5" disabled>{{$product->descriptions}}</textarea>
                  </div>
                </div>
              </div>
              <div class="modal-footer border-0 d-flex justify-content-around">
                <a class="btn btn-primary"href="{{route('admin.products.edit',$product->product_id)}}" >Sửa đổi</a>
                <a class="btn btn-danger" href="/admin/products">Quay lại</a>
              </div>
            
          </div>
        </div>
      </div>
</div>
@endsection