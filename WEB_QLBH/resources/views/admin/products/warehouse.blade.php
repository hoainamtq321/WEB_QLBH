@extends('admin.master')
@section('content')
<!--Thông báo -->
@if(session('success'))
    <div id="alert-danger" class="alert alert-danger" id="alert-danger" role="alert">
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
@if ($errors->any())
<div class="alert alert-danger" id="alert-danger" role="alert">
  Thêm sản phẩm thất bại hãy thử lại!
</div>
<script>
  setTimeout(function () {
      let alertBox = document.getElementById('alert-danger');
      if (alertBox) {
          alertBox.style.display = 'none';
      }
  }, 3000); // 5 giây
</script>
@endif
<!--Hết Thông báo -->

<div class="row">
    <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-center">
              <h4 class="card-title">Quản lý kho</h4>
              <button class="btn btn-primary btn-round ms-auto" onclick="showModel()">
                <i class="fa fa-plus"></i>
                Nhập kho
              </button>
            </div>
          </div>
          <div class="card-body">
            <!-- Modal -->
            <div class="modal" id="addRowModal" >
              <!--Beging Create  Form  Product-->
              <div class="modal-content">
                <div class="modal-header border-0">
                  <h5 class="modal-title">
                    <span class="fw-mediumbold">Thêm sản phẩm</span>
                  </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="showModel()">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p class="small">
                    Create a new row using this form, make sure you
                    fill them all
                  </p>
                  <form id="addData" action="{{route('admin.products.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="form-group form-group-default">
                          <label>Tên sản phẩm</label>
                          <input id="product_name" name="product_name" type="text" class="form-control" placeholder="Tên sản phẩm"/>
                        </div>
                      </div>
                      <div class="col-md-4 pe-0">
                        <div class="form-group form-group-default">
                          <label>Giá bán</label>
                          <input id="sell_price" name="sell_price" type="text" class="form-control"  placeholder="0"/>
                        </div>
                      </div>
                      <div class="col-md-4 pe-0">
                        <div class="form-group form-group-default">
                          <label>Giá nhập</label>
                          <input id="import_price" name="import_price" type="text" class="form-control"  placeholder="0"/>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group form-group-default">
                          <label>Tồn kho ban đầu</label>
                          <input id="quantity_in_stock"  name="quantity_in_stock" type="number" class="form-control" placeholder="0" />
                        </div>
                      </div>
  
                      <div class="col-md-12">
                        <div class="form-group form-group-default">
                          <label class="text-center">Ảnh sản phẩm</label>
                          <input type="file" name="img" id="fileInput" hidden>
                          <div class="col-md-12 d-flex  justify-content-center">
                            <div class="frame frame-select" onclick=addImg()>
                              <p>+</p>
                            </div>
                            <div class="frame d-none" onclick=addImg()>
                              <img  id="img" class="frame-avatar" src="/assets/img/upload/default.jpg" >
                            </div>
                          </div>
                        </div>
                      </div>
  
                      <div class="col-md-12">
                        <div class="form-group form-group-default">
                          <label>Mô tả</label>
                          <textarea class="w-100" id="description"  name="description" rows="3"></textarea>
                        </div>
                      </div>
  
                      <input type="text" name="create_by" id="create_by" value="{{Auth::user()->user_id}}" hidden>
  
                    </div>
                  </form>
                </div>
                <div class="modal-footer border-0">
                  <button type="button" id="addRowButton" class="btn btn-primary" onclick=addData()>Thêm</button>
                  <button type="button" class="btn btn-danger"  onclick="showModel()">Huỷ</button>
                </div>
              </div>
              <!--End Create  Form  Product-->
            </div>

            <div class="table-responsive">
              <table
                id="add-row"
                class="display table table-striped table-hover"
              >
                <thead>
                  <tr>
                    <th></th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Ngày tạo</th>
                    <th>Giá bán</th>
                    <th>Giá nhập</th>
                    <th style="width: 10%">Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th></th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Ngày tạo</th>
                    <th>Giá bán</th>
                    <th>Giá nhập</th>
                    <th style="width: 10%">Action</th>
                  </tr>
                </tfoot>
                <tbody>

                  @foreach ($products as $product)
                  <tr>
                    <td>
                      <div class="small-frame">
                        <img class="frame-avatar" src="/assets/img/upload/{{ $product->img}}" alt="" srcset="">
                      </div>
                    </td>
                    <td>{{ $product->product_name}}</td>
                    <td>{{ $product->quantity_in_stock}}</td>
                    <td>{{ date('d/m/Y', strtotime($product->created_at)) }}</td>
                    <td>{{ number_format($product->sell_price, 0, ',', '.') }}</td>
                    <td>{{ number_format($product->import_price, 0, ',', '.') }}</td>
                    <td>
                      <div class="form-button-action">
                        <a href="{{route('admin.products.show',$product->product_id)}}" type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">
                          <i class="fas fa-eye"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
                  @endforeach

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
</div>

<script src="/assets/js/myJS.js"></script>
@endsection