@extends('admin.master')
@section('content')

<div class="alert alert-danger d-none" id="alert-danger" role="alert">
    <!--Thông báo-->
</div>
<!--Khách hàng-->

<div class="card">
    <div class="card-body d-flex justify-content-end">
        @if($order_items[0]->status === 'Đang chờ')
            <form action="{{ route('admin.orders.update', $order_items[0]->order_id) }}" method="post">
                @method('PUT')
                @csrf
                <button class="btn btn-success" type="submit">Hoàn thành</button>
            </form>

            <form action="{{ route('admin.orders.destroy', $order_items[0]->order_id) }}" method="post" class="ms-3">
                @method('DELETE')
                @csrf
                <button class="btn btn-danger" type="submit">Huỷ đơn</button>
            </form>

        {{-- Nếu trạng thái là "hoàn thành", chỉ hiển thị nút Huỷ --}}
        @elseif($order_items[0]->status === 'Hoàn thành')
            <form action="{{ route('admin.orders.destroy', $order_items[0]->order_id) }}" method="post">
                @method('DELETE')
                @csrf
                <button class="btn btn-danger" type="submit">Huỷ đơn</button>
            </form>

        {{-- Nếu trạng thái là "đã huỷ", hiển thị nút huỷ bị disabled --}}
        @elseif($order_items[0]->status === "Đã huỷ")
            <button class="btn btn-secondary" disabled>Đã huỷ đơn</button>
        @endif
    </div>
</div>

<div class="row">
    
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Thông tin khách hàng</h4>
            </div>
            <div class="card-body">
                <div class="row" id="showCustomer">
                    <div class="col-md-4">
                        <div class="card-title text-center">{{$customer->name}}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-user ms-3">
                            <h5>{{$customer->phone}}</h5>
                            <div>{{$customer->address}}</div>
                         </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!--Sản phẩm-->
<div class="row">
    <div class="col-md-12">
        <div class="card">

            <div class="card-header">
                <h4 class="card-title">Thông tin sản phẩm</h4>
            </div>

        <div class="card-body">
            <table class="display table table-striped table-hover" id="showProduct">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" style="text-align: center">Ảnh</th>
                        <th scope="col">Tên sản phẩm</th>
                        <th scope="col">giá</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Thành tiền</th>
                    </tr>
                </thead>
                <tbody class="table-items">
                    <!--Hiển thị sản phẩm đã chọn-->
                    @foreach ($order_items as $item)
                    <tr class="items">
                        <td>1</td>
                        <td class="item-avatar">
                            <div class="avatar">
                                <img class="avatar-img rounded-circle" src="/assets/img/upload/{{$item->img}}" alt="">
                            </div>
                        </td>
                        <td class="item-name" style="width: 50%">{{$item->product_name}}</td> 
                        <td class="item-price">{{$item->sell_price}}</td>
                        <td class="item-quatilyty">{{$item->quantity}}</td>
                        <td class="item-total_price">{{$item->quantity*$item->sell_price}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

          </div>
        </div>
      </div>
</div>


<script src="/assets/js/orderJS.js"></script>
@endsection
