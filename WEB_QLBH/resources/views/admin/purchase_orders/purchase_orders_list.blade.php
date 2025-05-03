@extends('admin.master');
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-center">
              <h4 class="card-title">Danh sách đơn nhập</h4>
              <a href="{{route('admin.purchase_orders.create')}}" class="btn btn-primary btn-round ms-auto" >
                <i class="fa fa-plus"></i>
                Nhập hàng
              </a>
            </div>
          </div>
          <div class="card-body">
            <!-- Modal -->

            <div class="table-responsive">
              <table id="add-row" class="display table table-striped table-hover" >
                <thead>
                  <tr>
                    <th>Ngày nhập đơn</th>
                    <th>Tên nhà cung cấp</th>
                    <th>Trạng thái giao dịch</th>
                    <th>Tổng tiền</th>
                    <th style="width: 10%"></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($purchase_orders as $purchase_order)
                    <tr>
                      <td>{{ date('d/m/Y', strtotime($purchase_order->created_at)) }}</td>
                      <td>{{$purchase_order->name}}</td>
                      <td>
                        @php
                            switch ($purchase_order->status) {
                                case 'Đang giao dịch':
                                    $color = 'orange'; // vàng
                                    $text = 'Đang giao dịch';
                                    break;
                                case 'Đã thanh toán':
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
                      <td>{{ number_format($purchase_order->total) }}</td>
                      <td>
                        <div class="form-button-action">
                          <a href="{{route('admin.purchase_orders.edit',$purchase_order->purchase_order_id)}}" type="button" data-bs-toggle="tooltip" title=""  class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task" >
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