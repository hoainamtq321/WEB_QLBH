var products = [];
var customer_id;
//box search//

/*Customer*/

    // hiển thị khung tìm kiếm
var customerSearch = document.getElementById('customer-search_box');
var customerList = document.getElementById('customer-list'); 

customerSearch.addEventListener('click',function()
{
    customerList.classList.remove('d-none');

});

    // Ẩn khung tìm kiếm 
document.addEventListener('click', function (event) {
    if (!customerSearch.contains(event.target)) {
        customerList.classList.add('d-none');
    }
});


    // Chọn khách hàng và hiển thị

$(document).on('click',".customer-item",function(){
    $("#showCustomer").empty();
    $(".default-customer").addClass("d-none");
    $("#customer-search_box").val("");
    customer_id = $(this).data("id");
    let name = $(this).data("name");
    let phone = $(this).data("phone");
    let address = $(this).data("address");


    $("#showCustomer").append(`
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

    // Xoá khách hàng đã chọn
$(document).on('click',"#showCustomer .btn-danger",function(){
    $("#showCustomer").empty();
    $(".default-customer").removeClass("d-none");

    customer_id = null;

});


console.log(customer_id);


/*Products*/
    // hiển thị khung tìm kiếm
    var productSearch = document.getElementById('product-search_box');
    var productList = document.getElementById('product-list'); 
    
    productSearch.addEventListener('click',function()
    {
        productList.classList.remove('d-none');
    
    });

    
    // Ẩn khung tìm kiếm 
    document.addEventListener('click', function (event) {
        if (!productSearch.contains(event.target)) {
            productList.classList.add('d-none');

        }
    });

        // Tìm kiếm sản phẩm
        document.addEventListener('DOMContentLoaded', function () { // Chỉ chay sau khi đã load xong
                $("#product-search_box").on('input',function(){
        
                    clearTimeout(debounceTimeout); // Xoá timeout cũ nếu người dùng vẫn đang gõ
        
                    debounceTimeout = setTimeout(() => {
                        let query = $("#product-search_box").val() ;
        
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
                                    let searchResult = $("#returnProducts");// Nơi hiển thị kết quả
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
                                                <div class="item-list product-item" data-id="${element.product_id}" data-name="${element.product_name}" data-price="${element.sell_price}" data-img="${element.img || 'default.jpg'}">
                                                    <div class="info-user ms-3 d-flex">
                                                        <div class="avatar">
                                                            <img class="avatar-img rounded-circle" src="/assets/img/upload/${element.img || 'default.jpg'}" alt="">
                                                        </div>
                                                        <h5 class="name ms-3">${element.product_name}</h5>
                                                    </div>
                                                    <div class="price">${element.sell_price}</div>
                                                </div>
                                            `);
                                        
                                        });
                                    }
                                    
                                }
                            });
                        
                    }, 300); // Đợi 500ms sau khi người dùng ngừng g
                    
                    
                });
                
        
            })


    // Chọn sản phẩm

$(document).on('click',".product-item",function(){

    $(".default-product").addClass("d-none");
    $("#showProduct").removeClass("d-none");
    $("#product-search_box").val("");

    let product_id = $(this).data("id");
    let product_name = $(this).data("name");
    let sell_price = $(this).data("price");
    let img = $(this).data("img") || "default.jpg";
    let quantity = 1;
    let total = quantity*sell_price;

    // Kiểm tra sản phẩm đã tồn tại trong mảng chưa
    let existingProduct = products.find(product => product.product_id === product_id);

    if(existingProduct)
    {
        existingProduct.quantity += 1;
        existingProduct.total = existingProduct.quantity * existingProduct.sell_price;

        // Tăng số lượng và cập nhật tổng tiền trong bảng HTML
        let $row = $(`#showProduct .table-items tr[data-id='${product_id}']`);
        let $input = $row.find("input[type='number']");
        $input.val(existingProduct.quantity);
        $row.find(".item-total").text(existingProduct.total.toFixed(0));
    }
    else
    {

        products.push({
            product_id: product_id,
            product_name: product_name,
            sell_price: sell_price,
            quantity: quantity,
            total: total,
        });

    $("#showProduct .table-items").append(`
         <tr class="items" data-id="${product_id}">
            <td>1</td>
            <td class="item-avatar">
                <div class="avatar">
                    <img class="avatar-img rounded-circle" src="/assets/img/upload/${img}" alt="">
                </div>
            </td>
            <td class="item-name" style="width: 50%">${product_name}</td> 
            <td class="item-price">${sell_price}</td>
            <td class="item-quantity">
                <input type="number"  value="${quantity}">
            </td>
            <td class="item-total">${total}</td>
            <td class="item-delete">
                <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove" >
                    <i class="fa fa-times"></i>
                    </button>
            </td>
        </tr>
    `);

    }

});

    // Xoá sản phẩm đã chọn
$(document).on('click',"#showProduct .btn-danger",function(){
    const items =  $(this).closest(".items");
    const productId = items.data('id');

    // Xoá khỏi mảng products
    products = products.filter(p => p.product_id !== productId);
    
    items.remove();


    if ($("#showProduct").find(".items").length === 0) {
        $(".default-product").removeClass("d-none");
        $("#showProduct").addClass("d-none");
    }
});


$(document).on('change', '.item-quantity input', function () {
    let $row = $(this).closest('tr');
    let product_id = $row.data('id');
    let newquatility = parseInt($(this).val());

    if (isNaN(newquatility) || newquatility < 1) {
        newquatility = 1;
        $(this).val(1); // reset về 1 nếu nhập sai
    }

    // Cập nhật trong mảng products
    let product = products.find(p => p.product_id === product_id);
    if (product) {
        product.quantity = newquatility;
        product.total = product.sell_price * product.quantity;

        // Cập nhật lại tổng tiền trong bảng HTML
        $row.find('.item-total').text(product.total.toFixed(0));
    }
    console.log(products);
});


    // Tạo đơn hàng
    function clickMe()
    {

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'admin/orders',
            method: 'POST',
            data: {
                customer_id: customer_id,
                products: products
            },
            success: function (response) {
                console.log("Đặt hàng thành công:", response);
                window.location.href = '/admin/orders'; // 👉 Chuyển về trang Home
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

