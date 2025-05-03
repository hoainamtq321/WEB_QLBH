// Lọc kết quả theo ngày tháng năm
document.addEventListener('DOMContentLoaded', function () {
    $('#filterForm').on('click', function() {
        let startDate = $('#startDate').val();
        let endDate = $('#endDate').val();
        
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: "admin/product/search",
            data: { name: query },
            dataType: "json", // Đảm bảo phản hồi JSON
            success: function (response) {
            }
        });
        
    });
    
});