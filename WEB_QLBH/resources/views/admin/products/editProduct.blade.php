@extends('admin.master')
@section('content')
<div class="row">
    <div class="col-md-12">

      @if(session('success'))
        <div id="alert-success" class="alert alert-success" id="alert-danger" role="alert">
          {{session('success')}}
        </div>

        <script>
          setTimeout(function () {
            let alertBox = document.getElementById('alert-success');
            if (alertBox) {
                alertBox.style.display = 'none';
            }
          }, 5000); // 5 giây
        </script>
      @endif

        <div class="card">
          <div class="card-header">
            <h1>Sửa sản phẩm</h1>
          </div>
          <div class="card-body">
            <form id="addData" action="{{route('admin.products.update',$product->product_id)}}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group form-group-default">
                    <label>Tên sản phẩm</label>
                    <input id="product_name" name="product_name" type="text" class="form-control" placeholder="Tên sản phẩm" value="{{$product->product_name}}"/>
                  </div>
                </div>
                
                <div class="col-md-6 pe-0">
                  <div class="form-group form-group-default">
                    <label>Giá bán</label>
                    <input id="sell_price" name="sell_price" type="text" class="form-control"  placeholder="0" value="{{$product->sell_price}}"/>
                  </div>
                </div>
                <div class="col-md-6 pe-0">
                  <div class="form-group form-group-default">
                    <label>Giá nhập</label>
                    <input id="import_price" name="import_price" type="text" class="form-control"  placeholder="0" value="{{$product->import_price}}"/>
                  </div>
                </div>

                <div class="col-md-6">
                    <label class="text-center col-md-12">Ảnh thay đổi</label>
                    <div class="form-group form-group-default d-flex  justify-content-center">
                        <div class="col-md-6 d-flex  justify-content-center">
                            <input type="file" name="img" id="fileInput" hidden>
                            <div class="frame frame-select" onclick=addImg()>
                                <p>+</p>
                            </div>
                            <div class="frame d-none" onclick=addImg()>
                                <img  id="img" class="frame-avatar" src="/assets/img/upload/default.jpg" >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="text-center col-md-12">Ảnh hiện tại</label>
                    <div class="form-group form-group-default d-flex  justify-content-center">
                        <div class="col-md-6">
                            <div class="frame">
                                <img  id="img" class="frame-avatar" src="{{ asset('assets/img/upload/' . $product->img) }}">
                            </div>
                        </div>
                    </div>
                </div>
        
                <div class="col-md-12">
                  <div class="form-group form-group-default">
                    <label>Mô tả</label>
                    <textarea class="w-100" id="descriptions"  name="descriptions" rows="3"></textarea>
                  </div>
                </div>
              </div>
              <div class="modal-footer border-0 d-flex justify-content-around">
                <button type="submit" id="addRowButton" class="btn btn-primary">Lưu</button>
                <a class="btn btn-danger" href="/admin/products">Huỷ</a>
              </div>
            </form>
            
          </div>
        </div>
      </div>
</div>
@endsection