@extends('admin.master')
@section('content')

<!--Thông báo -->
@if(session('success'))
    <div id="alert-success" class="alert alert-success" id="alert-success" role="alert">
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
  Thêm khách hàng thất bại hãy thử lại!
</div>
<script>
  setTimeout(function () {
      let alertBox = document.getElementById('alert-danger');
          alertBox.style.display = 'none';
  }, 3000); // 5 giây
</script>
@endif
<!--Hết Thông báo -->

<div class="row">
    <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-center">
              <h4 class="card-title">Danh sách khách hàng</h4>
              <button class="btn btn-primary btn-round ms-auto" onclick="showModel()">
                <i class="fa fa-plus"></i>
                Thêm khách hàng
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
                    <span class="fw-mediumbold">Thêm khách hàng</span>
                  </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="showModel()">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p class="small"></p>
                  <form id="addData" action="{{route('admin.customers.store')}}" method="POST">
                    @csrf
                    <div class="row">

                      <div class="col-md-6">
                        <div class="form-group form-group-default">
                          <label>Tên khách hàng</label>
                          <input id="name" name="name" type="text" class="form-control" placeholder="Tên khách hàng"/>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group form-group-default">
                          <label>Số điện thoại</label>
                          <input id="phone" name="phone" type="text" class="form-control"  placeholder="Số điện thoại"/>
                        </div>
                      </div>
  
                      <div class="col-sm-12">
                        <div class="form-group form-group-default">
                          <label>Địa chỉ</label>
                          <input id="address" name="address" type="text" class="form-control" placeholder="Địa chỉ"/>
                        </div>
                      </div>
  
                    </div>
                  </form>
                </div>
                <div class="modal-footer border-0">
                  <button type="button" id="addRowButton" class="btn btn-primary" onclick=addData()>Thêm</button>
                  <button type="button" class="btn btn-danger"  onclick="showModel()">Huỷ</button>
                </div>
              </div>
            </div>

            <div class="table-responsive">
              <table id="add-row" class="display table table-striped table-hover">
                <thead>
                  <tr>
                    <th>Tên khách hàng</th>
                    <th>số điện thoại</th>
                    <th>Tổng số lượng đơn</th>
                    <th style="width: 10%">Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Tên khách hàng</th>
                    <th>Số điện thoại</th>
                    <th>Tổng số lượng đơn</th>
                    <th>Action</th>
                  </tr>
                </tfoot>
                <tbody>
                  @foreach ($customers as $customer )
                  <tr>
                    <td>{{$customer->name}}</td>
                    <td>{{$customer->phone}}</td>
                    <td>{{$customer->total_orders}}</td>
                    <td>
                      <div class="form-button-action">
                        <a href="{{route('admin.customers.edit',$customer->customer_id)}}" type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">
                          <i class="fa fa-edit"></i>
                        </a>
                        <button type="button" data-id="{{$customer->customer_id}}" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger btn-delete" data-original-title="Remove">
                          <i class="fa fa-times"></i>
                        </button>
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
<form  id="removeData" action="{{route('admin.customers.destroy',"")}}" method="post">
  @method('DELETE')
  @csrf
  </form>
@endsection