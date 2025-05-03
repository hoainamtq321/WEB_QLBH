@extends('admin.master')
@section('content')
<div class="row">
    <p class="demo">
      <button onclick="create()" class="btn btn-info">Tạo phiếu</button>
      <a href="/admin/stock_adjustments" class="btn btn-danger">Huỷ</a>
    </p>
</div>
<div class="row">
  <div class="col-md-8">
    <div class="card">
      <div class="card-header">
        <b>Thông tin phiếu kiểm</b>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <p>Người tạo: {{ Auth::check() ? Auth::user()->full_name : 'Chưa đăng nhập' }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card">
      <div class="card-header">
        <b>Thông tin bổ sung</b>
      </div>
      <div class="card-body row">
        <label for="">Ghi chú:</label>
        <div class="col-md-12">
          <textarea class="w-100" name="" id="" cols="5"></textarea>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
          <div class="card-header">
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
          <div class="card-body">
            <table class="display table table-striped table-hover" id="chooseBox_search-2">
              <thead>
                  <tr style="text-align: center">
                      <th scope="col">STT</th>
                      <th scope="col">Ảnh</th>
                      <th scope="col">Tên sản phẩm</th>
                      <th scope="col">Tồn hệ thống</th>
                      <th scope="col">Tồn thực tế</th>
                      <th scope="col">lệch</th>
                      <th scope="col">Ghi chú</th>
                      <th scope="col" style="width: 5%"></th>
                  </tr>
              </thead>
              <tbody class="table-items">
              </tbody>
            </table>
            <div id="default" class="">
              <h4 style="text-align: center">Chưa có sản phẩm</h4>
            </div>
          </div>
        </div>
      </div>
</div>
<script src="/assets/js/stock_adjustments.js"></script>
@endsection