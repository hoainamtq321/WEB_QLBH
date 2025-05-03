// Khai báo biến trước
let debounceTimeout = null; // Xem hành vi nhập của người dùng

var supplier_id = null;
var products = [];

// Ô tìm kiếm
$("#box_search-1");
$("#box_search-2");

// Khung hiển thị kết quả tìm kiếm
$("#showBox_search-1");
$("#showBox_search-2");
    // Kết quả tìm kiếm
    $("#returnBox_searrch-1");
    $("#returnBox_searrch-2");
// Hiển thị kết quả chọn
$("#chooseBox_search-1");
$("#chooseBox_search-2");

// Action

    // Hiển thị khung tìm kiếm
$('#box_search-1').on('click', function() {
    $("#showBox_search-1").removeClass("d-none");
});
$('#box_search-2').on('click', function() {
    $("#showBox_search-2").removeClass("d-none");
});
    // Ẩn khung tìm kiếm
$(document).on('click', function (event) {
    if (!$('#box_search-1')[0].contains(event.target)) {
        $("#showBox_search-1").addClass("d-none");
    }
});
$(document).on('click', function (event) {
    if (!$('#box_search-2')[0].contains(event.target)) {
        $("#showBox_search-2").addClass("d-none");
    }
});
    // Tìm kiếm 
    


// Box_search1
    // Hiển thị kết quả Box_search-1
document.addEventListener('DOMContentLoaded', function () {
    // Chỉ chay sau khi đã load xong 
    $(document).on('input','#box_search-1',function(){
        clearTimeout(debounceTimeout); 
        debounceTimeout = setTimeout(() => {
            let query = $("#box_search-1").val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "GET",
                url: "/admin/suppliers/search",
                data: { name: query },
                dataType: "json", // Đảm bảo phản hồi JSON
                success: function (response) {
                    
                    let searchResult = $("#returnBox_searrch-1");// Nơi hiển thị kết quả
                    searchResult.empty(); // Xoá kết quả cũ
                    if(!Array.isArray(response) || response.length === 0)
                    {
                        searchResult.append(`
                            <h4 class="card-title text-center">Không tìm thấy khách hàng</h4>
                        `)
                    }
                    else
                    {
                        // console.log(response);
                        response.forEach(element => {
                            searchResult.append(`
                                <div class="item-list customer-item" data-id="${element.supplier_id}" data-name="${element.name}" data-phone="${element.phone}" data-address="${element.address}">
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

        },300);
        
    });  

});

    // Chọn items trong Box_search-2
$(document).on('click',"#returnBox_searrch-1 .item-list",function(){

    $("#chooseBox_search-1").empty();
    $(".default-customer").addClass("d-none");
    $("#box_search-1").val("");
    supplier_id = $(this).data("id");
    let name = $(this).data("name");
    let phone = $(this).data("phone");
    let address = $(this).data("address");


    $("#chooseBox_search-1").append(`
        <div class="col-md-4">
            <div class="card-title text-center">${name}</div>
        </div>
        <div class="col-md-6">
            <div class="info-user ms-3">
                <h5>${phone}</h5>
                <div>${address}</div>
             </div>
        </div>
        <div class="col-md-2">
            <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove" >
                <i class="fa fa-times"></i>
            </button>
        </div>
    `);
})
    
    // Xoá item đã chọn trong box_search-1
$(document).on('click',"#chooseBox_search-1 .btn-danger",function(){
    $("#chooseBox_search-1").empty();
    $(".default-customer").removeClass("d-none");
    
    supplier_id = null;
    
});


// Box_search2
document.addEventListener('DOMContentLoaded', function () { // Chỉ chay sau khi đã load xong
    $("#box_search-2").on('input',function(){

        clearTimeout(debounceTimeout); // Xoá timeout cũ nếu người dùng vẫn đang gõ

        debounceTimeout = setTimeout(() => {
            let query = $("#box_search-2").val() ;

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "GET",
                    url: "admin/products/search",
                    data: { name: query },
                    dataType: "json", // Đảm bảo phản hồi JSON
                    success: function (response) {
                        //console.log(response);
                        let searchResult = $("#returnBox_searrch-2");// Nơi hiển thị kết quả
                        searchResult.empty(); // Xoá kết quả cũ
                        if(!Array.isArray(response) || response.length === 0)
                        {
                            searchResult.append(`
                                <h4 class="card-title text-center">Không tìm thấy sản phẩm</h4>
                            `)
                        }
                        else
                        {
                            response.forEach(element => {
                                searchResult.append(`
                                    <div class="item-list product-item" data-id="${element.product_id}" data-name="${element.product_name}" data-price="${element.import_price}" data-img="${element.img || 'default.jpg'}">
                                        <div class="info-user ms-3 d-flex">
                                            <div class="avatar">
                                                <img class="avatar-img rounded-circle" src="/assets/img/upload/${element.img || 'default.jpg'}" alt="">
                                            </div>
                                            <h5 class="name ms-3">${element.product_name}</h5>
                                        </div>
                                        <div class="price">${element.import_price}</div>
                                    </div>
                                `);
                            
                            });
                        }
                        
                    }
                });
            
        }, 300); // Đợi 500ms sau khi người dùng ngừng g
        
        
    });
})

    // Chọn items trong Box_search-2
$(document).on('click',".product-item",function(){

    $(".default-product").addClass("d-none");
    $("#chooseBox_search-2").removeClass("d-none");
    $("#box_search-2").val("");

    let product_id = $(this).data("id");
    let product_name = $(this).data("name");
    let import_price = $(this).data("price");
    let img = $(this).data("img") || "default.jpg";
    let quantity = 1;
    let total = 0;
    if(import_price!==0)
    {
        total = quantity*import_price;
    }

    
    let product = products.find(product => product.product_id === product_id);
    // Kiểm tra sản phẩm đã tồn tại trong mảng chưa
    if(product)
    {
        // Tăng số lượng và cập nhật tổng tiền trong bảng HTML
        product.quantity =  parseInt(product.quantity) + 1;
        let row = $(`#chooseBox_search-2 tr[data-id='${product_id}']`);
        let quantity = row.find(".item-quantity input");
        quantity.val(product.quantity);

        if(product.sell_price !==0)
        {
            row.find(".item-total").text(product.quantity*product.import_price);
        };
        
        
    }
    else
    {
        products.push({
            product_id: product_id,
            product_name: product_name,
            import_price: import_price,
            quantity: quantity,
        });

    // Hiển thị sản phẩm chọn
        $("#chooseBox_search-2 .table-items").append(`
            <tr class="items" data-id="${product_id}">
                <td>1</td>
                <td class="item-avatar">
                    <div class="avatar">
                        <img class="avatar-img rounded-circle" src="/assets/img/upload/${img}" alt="">
                    </div>
                </td>
                <td class="item-name" style="width: 50%">${product_name}</td> 
                <td class="item-price">
                    <input type="number" pattern="\d*" title="Chỉ nhập số" name="import_price" value=${import_price}>
                </td>
                <td class="item-quantity">
                    <input class="wd-50px" type="number" name="quantity"  value="${quantity}">
                </td>
                <td class="item-total">${quantity*import_price}</td>
                <td class="item-delete">
                    <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove" >
                        <i class="fa fa-times"></i>
                        </button>
                </td>
            </tr>
        `);

    }

});

    // Xoá item đã chọn box_search-2
    $(document).on('click',"#chooseBox_search-2 .btn-danger",function(){
        const items =  $(this).closest(".items");
        const productId = items.data('id');
    
        // Xoá khỏi mảng products
        products = products.filter(p => p.product_id !== productId);
        items.remove();
    
    
        if ($("#chooseBox_search-2").find(".items").length === 0) {
            $(".default-product").removeClass("d-none");
            $("#chooseBox_search-2").addClass("d-none");
        }
    });
    
    // Cập nhật giá nhập và thành tiền
$(document).on('input','.item-price input', function () {

    let row = $(this).closest('tr');
    let product_id = row.data('id');
    let quantity =  row.find('.item-quantity input').val();
    row.find('.item-total').text($(this).val()*quantity);
    // Cập nhật giá sp
    let product = products.find(product => product.product_id === product_id);
    product.import_price = $(this).val();
});
   
    // Tăng số lượng va thanh tien
$(document).on('change', '.item-quantity input', function () {
    let row = $(this).closest('tr');
    let product_id = row.data('id');
    let newQuantity = $(this).val();
    let import_price =  row.find('.item-price input').val();
    let total = row.find('.item-total');
    total.text($(this).val()*import_price);

    if (isNaN(newQuantity) || newQuantity < 1) {
        newQuantity = 1;
        $(this).val(1); // reset về 1 nếu nhập sai
        if(import_price !==0)
        {
            total.text(import_price);
        }
    }

    // Cập nhật số lượng sp
    let product = products.find(product => product.product_id === product_id);
    product.quantity = newQuantity;

});


// Tạo đơn nhập hàng
function clickMe()
{

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: 'admin/purchase_orders',
        method: 'POST',
        data: {
            supplier_id: supplier_id,
            products: products
        },
        success: function (response) {
            console.log("Nhập hàng thành công:", response);
            window.location.href = '/admin/purchase_orders'; // 👉 Chuyển về trang Home
        },
        error: function (xhr) {
            let res = xhr.responseJSON;
            let msg = res?.message || 'Có lỗi xảy ra';
            let mess = "Lỗi khi đặt hàng:" + msg;
            $("#alert-danger").removeClass('d-none');
            $("#alert-danger").text(mess);

            setTimeout(function () {
                let alertBox = $("#alert-danger");
                if (alertBox) {
                    alertBox.addClass('d-none');
                }
            }, 5000); // 5 giây
        }
    });
}

