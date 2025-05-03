@extends('admin.master')
@section('content')
<!--Khách hàng-->
<div class="alert alert-danger d-none" id="alert-danger" role="alert">
    Thêm sản phẩm thất bại hãy thử lại!
</div>
<div class="row">
    
    <div class="col-md-12">
        <div class="card">
            <!--Tìm kiếm khách hàng-->
            <div class="card-header">
                <h4 class="card-title">Thông tin khách hàng</h4>
                <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-lg-flex">
                    <div class="input-group">
                      <div class="input-group-prepend">
                          <button type="submit" class="btn btn-search pe-1">
                              <i class="fa fa-search search-icon"></i>
                          </button>
                      </div>
                      <input type="text" class="form-control" name="" id="customer-search_box">
                    </div>
                </nav>
                <div class="row box d-none" id="customer-list">
                    <div class="col-md-12 position-absolute">
                        <div class="card frame-search">
                            <div class="card-body">
                                <div class="card-list" id="returnCustomers">
                                    <!--Hiển thị kết quả tìm kiếm khách hàng-->
                                    <h4 class="card-title text-center">Nhập tên khách hàng</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--Kết thúc tìm kiếm khách hàng-->

            <div class="card-body">

                <div class="card-title text-center default-customer">Chưa có thông tin khách hàng</div>
                <div class="row" id="showCustomer">
                    <!--Hiển thị khách hàng đã chọn-->
                </div>

            </div>
        </div>
    </div>
</div>

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
                      <input type="text" class="form-control" name="" id="product-search_box">
                    </div>
                </nav>
                <div class="row box d-none" id="product-list">
                    <div class="col-md-12 position-absolute">
                        <div class="card frame-search">
                            <div class="card-body">
                                <div class="card-list" id="returnProducts">
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

            <table class="display table table-striped table-hover d-none" id="showProduct">
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
<button class="btn btn-primary" type="button" onclick="clickMe()">Tạo đơn</button>
<form  id="removeData" action="{{route('admin.customers.destroy',"")}}" method="post">
  @method('DELETE')
  @csrf
</form>
<script src="/assets/js/orderJS.js"></script>

<script>
let debounceTimeout = null; // Khai báo biến trước
document.addEventListener('DOMContentLoaded', function () { // Chỉ chay sau khi đã load xong
        customerSearch.addEventListener('input',function(event){

            clearTimeout(debounceTimeout); // Xoá timeout cũ nếu người dùng vẫn đang gõ

            debounceTimeout = setTimeout(() => {
                let query = customerSearch.value ;
                console.log(query);
                
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "GET",
                        url: "{{route('admin.customers.search')}}",
                        data: { name: query },
                        dataType: "json", // Đảm bảo phản hồi JSON
                        success: function (response) {
                            let searchResult = $("#returnCustomers");// Nơi hiển thị kết quả
                            searchResult.empty(); // Xoá kết quả cũ
                            if(!Array.isArray(response) || response.length === 0)
                            {
                                searchResult.append(`
                                    <h4 class="card-title text-center">Không tìm thấy khách hàng</h4>
                                `)
                            }
                            else
                            {
                                response.forEach(element => {
                                    searchResult.append(`
                                        <div class="item-list customer-item" data-id="${element.customer_id}" data-name="${element.name}" data-phone="${element.phone}" data-address="${element.address}">
                                            <div class="avatar">
                                                <img class="avatar-img rounded-circle" src="/assets/img/upload/default.jpg" alt="">
                                            </div>
                                            <div class="info-user ms-3">
                                                <h5 class="name">${element.name}</h5>
                                                <div class="phone">${element.phone}</div>
                                            </div>
                                        </div>
                                    `);
                                
                                });
                            }
                            
                            
                        }
                    });
                
            }, 300); // Đợi 500ms sau khi người dùng ngừng g
            
            
        });
        

    })
</script>

@endsection
