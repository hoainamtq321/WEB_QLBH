@extends('admin.master')
@section('content')

<!--Nhà cung cấp-->
<div class="row">
    
    <div class="col-md-12">
        <div class="card">
            <!--Tìm kiếm Nhà cung cấp-->
            <div class="card-header">
                <h4 class="card-title">Thông tin Nhà cung cấp</h4>
                <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-lg-flex">
                    <div class="input-group">
                      <div class="input-group-prepend">
                          <button type="submit" class="btn btn-search pe-1">
                              <i class="fa fa-search search-icon"></i>
                          </button>
                      </div>
                      <input type="text" class="form-control" name="" id="box_search-1">
                    </div>
                </nav>
                <!--Hiển thị kết quả tìm kiếm Nhà cung cấp-->
                <div class="row box d-none" id="showBox_search-1">
                    <div class="col-md-12 position-absolute">
                        <div class="card frame-search">
                            <div class="card-body">
                                <div class="card-list" id="returnBox_searrch-1">
                                    <!--Kết quả tìm kiếm-->
                                    <h4 class="card-title text-center">Nhập tên Nhà cung cấp</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Kết thúc hiển thị -->
            </div>
            <!--Kết thúc tìm kiếm Nhà cung cấp-->

            <div class="card-body">

                <div class="card-title text-center default-customer">Chưa có thông tin Nhà cung cấp</div>
                <div class="row" id="chooseBox_search-1">
                    <!--Hiển thị Nhà cung cấp đã chọn-->
                </div>

            </div>
        </div>
    </div>
</div>
<!--END nhà cung cấp-->

<!--Sản phẩm-->
<div class="row">
    <div class="col-md-12">
        <div class="card">

            <!--Tìm kiếm sản phẩm-->
            <div class="card-header">
                <h4 class="card-title">Thông tin sản phẩm</h4>
                <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-lg-flex">
                    <div class="input-group">
                      <div class="input-group-prepend">
                          <button type="submit" class="btn btn-search pe-1">
                              <i class="fa fa-search search-icon"></i>
                          </button>
                      </div>
                      <input type="text" class="form-control" name="" id="box_search-2">
                    </div>
                </nav>
                <div class="row box d-none" id="showBox_search-2">
                    <div class="col-md-12 position-absolute">
                        <div class="card frame-search">
                            <div class="card-body">
                                <div class="card-list" id="returnBox_searrch-2">
                                    <!--Kết quả tìm kiếm sản phẩm-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--Kết thúc tìm kiếm sản phẩm-->

        <div class="card-body">
            <div class="default-product">
                <h4 class="card-title text-center">Chưa có thông tin sản phẩm</h4>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" id="" class="btn btn-primary">Thêm sản phẩm</button>
                </div>
            </div>

            <table class="display table table-striped table-hover d-none" id="chooseBox_search-2">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" style="text-align: center">Ảnh</th>
                        <th scope="col">Tên sản phẩm</th>
                        <th scope="col">giá</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Thành tiền</th>
                        <th scope="col" style="width: 5%"></th>
                    </tr>
                </thead>
                <tbody class="table-items">
                    <!--Hiển thị sản phẩm đã chọn-->
                </tbody>
            </table>

          </div>
        </div>
      </div>
</div>
<button class="btn btn-primary" type="button" onclick="clickMe()">Nhập hàng</button>
<form  id="removeData" action="{{route('admin.customers.destroy',"")}}" method="post">
  @method('DELETE')
  @csrf
</form>
<script src="/assets/js/purchase_orders.js"></script>

<script>

</script>

@endsection