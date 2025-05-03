@extends('admin.master')
@section('content')
<div class="row demo">
  <div class="col-md-12">
    <div class="modal-footer border-0">
      <button class="btn btn-black demo">Xuất file</button>
      @switch($stock_adjustments->status)
        @case("Đang kiểm kho")
          <form method="POST" action="{{route('admin.stock_adjustments.update',$stock_adjustments->stock_adjustment_id)}}">
            @csrf
            @method('PUT')
              <button type="submit" class="btn btn-info mx-3">Cân bằng</button>
          </form>
          <form method="POST" action="{{route('admin.stock_adjustments.destroy',$stock_adjustments->stock_adjustment_id)}}">
            @csrf
            @method('DELETE')
              <button type="submit" class="btn btn-danger">Huỷ</button>
          </form>
          @break
        @case("Hoàn thành")
          <form method="POST" action="{{route('admin.stock_adjustments.destroy',$stock_adjustments->stock_adjustment_id)}}">
          @csrf
          @method('DELETE')
            <button type="submit" class="btn btn-danger">Huỷ</button>
          </form>
          @break
        @default
            <button type="button" class="btn btn-danger mx-3" disabled>Huỷ</button>
      @endswitch
    </div>
  </div>
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
            <p>Người tạo: {{$stock_adjustments->full_name}}</p>
            <p>Người kiểm: {{$stock_adjustments->full_name}}</p>
          </div>
          <div class="col-md-6">
            <p>Ngày tạo: {{date('d/m/Y', strtotime($stock_adjustments->created_at))}}</p>
            <p>Ngày cân bằng: {{date('d/m/Y', strtotime($stock_adjustments->updated_at))}}</p>
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
                @foreach ($stock_adjustment_items as $index => $item)
                <tr style="text-align: center">
                  <td scope="col">{{ $index+1}}</td>
                  <td scope="col">
                    <div class="avatar">
                      <img class="avatar-img rounded-circle" src="/assets/img/upload/{{$item->img}}" alt="">
                    </div>
                  </td>
                  <td scope="col">{{$item->product_name}}</td>
                  <td scope="col">{{$item->system_inventory}}</td>
                  <td scope="col">{{$item->physical_inventory}}</td>
                  <td scope="col">{{$item->system_inventory - $item->physical_inventory}}</td>
                  <td scope="col">{{$item->note}}</td>
                  <td scope="col" style="width: 5%"></td>
              </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
</div>
@endsection