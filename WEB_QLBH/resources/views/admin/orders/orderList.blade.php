@extends('admin.master');
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-center">
              <h4 class="card-title">Danh sách đơn hàng</h4>
              <a href="/admin/orders/create" class="btn btn-primary btn-round ms-auto" >
                <i class="fa fa-plus"></i>
                Tạo đơn
              </a>
            </div>
          </div>
          <div class="card-body">
            <!-- Modal -->

            <div class="table-responsive">
              <table id="add-row" class="display table table-striped table-hover" >
                <thead>
                  <tr>
                    <th>Ngày tạo đơn</th>
                    <th>Tên khách hàng</th>
                    <th>Trạng thái</th>
                    <th>Khách phải trả</th>
                    <th style="width: 10%">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($orders as $order)
                    <tr>
                      <td>{{ date('d/m/Y', strtotime($order->created_at)) }}</td>
                      <td>{{$order->customer_name}}</td>
                      <td>
                        @php
                            switch ($order->status) {
                                case 'Đang chờ':
                                    $color = 'orange'; // vàng
                                    $text = 'Đang chờ';
                                    break;
                                case 'Hoàn thành':
                                    $color = 'green';
                                    $text = 'Hoàn thành';
                                    break;
                                default:
                                    $color = 'red';
                                    $text = 'Đã huỷ';
                                  
                            }
                        @endphp
                      
                        <span style="color: {{ $color }}">
                            {{ $text }}
                        </span>
                      </td>
                      <td>{{ number_format($order->total) }}</td>
                      <td>
                        <div class="form-button-action">
                          <a href="{{route('admin.orders.edit',$order->order_id)}}" type="button" data-bs-toggle="tooltip" title=""  class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task" >
                            <i class="fa fa-edit"></i>
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
@endsection