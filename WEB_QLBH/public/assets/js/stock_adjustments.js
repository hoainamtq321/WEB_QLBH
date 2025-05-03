// Khai báo biến trước
let debounceTimeout = null; // Xem hành vi nhập của người dùng

let products = [];
// Box_search2
$('#box_search-2').on('click', function() {
    $("#showBox_search-2").removeClass("d-none");
});

$(document).on('click', function (event) {
    if (!$('#box_search-2')[0].contains(event.target)) {
        $("#showBox_search-2").addClass("d-none");
    }
});

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
                                    <div class="item-list product-item" data-id="${element.product_id}" data-name="${element.product_name}" data-quantity="${element.quantity_in_stock}" data-img="${element.img || 'default.jpg'}">
                                        <div class="info-user ms-3 d-flex">
                                            <div class="avatar">
                                                <img class="avatar-img rounded-circle" src="/assets/img/upload/${element.img || 'default.jpg'}" alt="">
                                            </div>
                                            <h5 class="name ms-3">${element.product_name}</h5>
                                        </div>
                                        <div class="quantity">Tồn kho:${element.quantity_in_stock}</div>
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

    $("#default").addClass("d-none");
    $("#box_search-2").val("");
    let product_id = $(this).data("id");
    let product_name = $(this).data("name");
    let quantity = $(this).data("quantity");
    let img = $(this).data("img") || "default.jpg";
    let count = $("#chooseBox_search-2 .table-items .items").length;

    $product = products.find(product => product.product_id === product_id);

    if($product)
    {

    }
    else
    {
        products.push({
            product_id: product_id,
            system_inventory: quantity,
            physical_inventory: null,
            note:null,
        });

        // Hiển thị sản phẩm chọn
        $("#chooseBox_search-2 .table-items").append(`
            <tr class="items" data-id="${product_id}" style="text-align: center">
                  <td>${count+1}</td>
                  <td class="item-avatar">
                      <div class="avatar">
                          <img class="avatar-img rounded-circle" src="/assets/img/upload/${img}" alt="">
                      </div>
                  </td>
                  <td class="item-name">${product_name}</td> 
                  <td class="item-system_inventory">${quantity}</td>
                  <td class="item-physical_inventory">
                    <input type="number" name="physical_inventory" id="" style="width: 50px">
                  </td>
                  <td class="item-deviation"></td>
                  <th scope="col" class="item-note">
                    <input type="text" name="item-note" id="" style="width: 100px">
                  </th>
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
        $("#default").removeClass("d-none");
    }
    
});

// Nhập tồn kho thực tế
$(document).on('input',"#chooseBox_search-2 .item-physical_inventory input",function(){

    let row = $(this).closest("tr");
    let product_id = row.data('id');
    let system = parseInt(row.find(".item-system_inventory").text());
    let physical = $(this).val();
    let deviation = physical - system;
    row.find(".item-deviation").text(deviation);

    let product = products.find(product => product.product_id === product_id);
    product.physical_inventory = $(this).val();
});

// Thêm ghi chú
$(document).on('input',"#chooseBox_search-2 .item-note input",function(){
    clearTimeout(debounceTimeout); // Xoá timeout cũ nếu người dùng vẫn đang gõ
        debounceTimeout = setTimeout(() => {
            let row = $(this).closest("tr");
            let product_id = row.data('id');
            let product = products.find(product => product.product_id === product_id);
            product.note = $(this).val();
        },1000);
});

// Tạo đơn nhập hàng
function create()
{
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/admin/stock_adjustments',
        method: 'POST',
        data: {
            products: products
        },
        success: function (response) {
            console.log("Nhập hàng thành công:", response);
            window.location.href = '/admin/stock_adjustments'; // 👉 Chuyển về trang Home
        },
        error: function (xhr) {
            let res = xhr.responseJSON;
            let msg = res?.message || 'Có lỗi xảy ra';
            let mess = "Lỗi:" + msg;
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