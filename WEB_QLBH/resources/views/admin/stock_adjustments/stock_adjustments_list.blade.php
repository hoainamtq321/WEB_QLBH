@extends('admin.master')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="demo">
              <a href="/admin/stock_adjustments/create" class="btn btn-info">Tạo phiếu kiểm</a>
            </div>
          </div>
          <div class="card-body">
            <table class="display table table-striped table-hover" id="chooseBox_search-2">
              <thead>
                  <tr>
                      <th scope="col">#</th>
                      <th scope="col">Trạng thái</th>
                      <th scope="col">Ngày tạo</th>
                      <th scope="col">Ngày cân bằng</th>
                      <th scope="col">Người kiểm</th>
                      <th scope="col" style="width: 5%"></th>
                  </tr>
              </thead>
              <tbody class="table-items">
                @foreach ($stock_adjustments as $item)
                  <tr class="items" data-id="">
                    <td>{{$item->stock_adjustment_id}}</td>
                    <td>
                      @php
                        
                          switch ($item->status) {
                              case 'Đang kiểm kho':
                                  $color = 'orange'; // vàng
                                  $text = 'Đang giao dịch';
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
                    <td class="">{{ date('d/m/Y', strtotime($item->created_at))}}</td> 
                    <td class="">{{ date('d/m/Y', strtotime($item->updated_at))}}</td>
                    <td class="">{{$item->full_name}}</td>
                    <td class="item-delete">
                      <a href="/admin/stock_adjustments/{{$item->stock_adjustment_id}}/edit" class="btn btn-link btn-primary btn-lg">
                          <i class="fas fa-eye"></i>
                      </a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
</div>
@endsection