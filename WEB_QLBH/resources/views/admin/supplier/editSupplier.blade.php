@extends('admin.master')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
    <!--Thông báo-->
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
    <!--End thông báo-->
        <div class="card">
          <div class="card-header">
            <h1>Sửa nhà cung cấp</h1>
          </div>
          <div class="card-body">
            
            <form id="addData" action="{{route('admin.supplier.update',$supplier->supplier_id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">

                  <div class="col-md-6">
                    <div class="form-group form-group-default">
                      <label>Tên nhà cung cấp</label>
                      <input id="name" name="name" type="text" class="form-control" placeholder="Tên khách hàng" value="{{$supplier->name}}"/>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group form-group-default">
                      <label>Số điện thoại</label>
                      <input id="phone" name="phone" type="text" class="form-control"  placeholder="Số điện thoại" value="{{$supplier->phone}}"/>
                    </div>
                  </div>

                  <div class="col-sm-12">
                    <div class="form-group form-group-default">
                      <label>Địa chỉ</label>
                      <input id="address" name="address" type="text" class="form-control" placeholder="Địa chỉ" value="{{$supplier->address}}"/>
                    </div>
                  </div>

                </div>

                <div class="modal-footer border-0 d-flex justify-content-around">
                  <button type="submit" id="addRowButton" class="btn btn-primary" >Lưu</button>
                  <a class="btn btn-danger" href="/admin/suppliers">Huỷ</a>
                </div>
            </form>

          </div>
        </div>
      </div>
</div>
@endsection