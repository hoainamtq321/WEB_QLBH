@extends('admin.master')
@section('content')


<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-7">
                        <h4 class="card-title">Doanh thu cửa hàng</h4>
                        <p>7 ngày qua</p>
                    </div>
                    <div class="col-md-5">
                        <h3>
                            @php
                                $totalRevenue = 0;
                                foreach ($final as $item) {
                                    $totalRevenue += $item['total'];
                                }
                            @endphp
                            {{$totalRevenue}}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="myfirstchart" style="height: 250px;"></div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Thông tin đơn hàng</h4>
            </div>
            <div class="card-body" >
                <div class="card-body">
                    <div id="orderchart" style="height: 250px;"></div>
                    <div class="" style="height: 50px"></div>
                    <div style="color: #dc3545;" class="row">
                        <p style="background-color: #dc3545; height: 21px" class="col-md-1"></p>
                        <p style="color: #dc3545;" class="col-md-6">Huỷ đơn</p>
                    </div>
                    <div class="row">
                        <p style="background-color: #FFA500; height: 21px" class="col-md-1"></p>
                        <p style="color: #FFA500;" class="col-md-6">Đang chờ</p>
                    </div>
                    <div class="row">
                        <p style="background-color: #28a745; height: 21px" class="col-md-1"></p>
                        <p style="color: #28a745;" class="col-md-6">Hoàn thành</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <form action="" class="row">
                    <div class="col-md-4">
                        <label for="">Từ ngày</label>
                        <input class="form-control" type="text" id="startDate">
                    </div>
                    <div class="col-md-4">
                        <label for="">Đến ngày</label>
                        <input class="form-control" type="text" id="endDate">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for=""></label>
                        <button class="btn btn-primary" type="button" id="filterForm">Lọc kết quả</button>
                    </div>
                    
                </form>
            </div>
            <div class="card-body">
                
            </div>
        </div>
    </div>
</div>
<div>
    
</div>
<script>
    $( function() {
      $( "#startDate" ).datepicker({
        prevText: 'Tháng trước',
        nextText: 'Tháng sau',
        dateFormat: 'yy-mm-dd',
        dayNamesMin : ['Thứ 2','Thứ 3','Thứ 4','Thứ 5','Thứ 6','Thứ 7','Chủ nhât'],
        duration: 'slow'
      });
    } );
    $( function() {
      $( "#endDate" ).datepicker({
        prevText: 'Tháng trước',
        nextText: 'Tháng sau',
        dateFormat: 'yy-mm-dd',
        dayNamesMin : ['Thứ 2','Thứ 3','Thứ 4','Thứ 5','Thứ 6','Thứ 7','Chủ nhât'],
        duration: 'slow'
      });
    } );

console.log();


    new Morris.Bar({
  // ID of the element in which to draw the chart.
  element: 'myfirstchart',
  // Chart data records -- each entry in this array corresponds to a point on
  // the chart.
  data: [
    { year: {{ $final[0]['day'] }}, 'Doanh số': {{ $final[0]['total'] }} },
    { year: {{ $final[1]['day'] }}, 'Doanh số': {{ $final[1]['total'] }} },
    { year: {{ $final[2]['day'] }}, 'Doanh số': {{ $final[2]['total'] }} },
    { year: {{ $final[3]['day'] }}, 'Doanh số': {{ $final[3]['total'] }} },
    { year: {{ $final[4]['day'] }}, 'Doanh số': {{ $final[4]['total'] }} },
    { year: {{ $final[5]['day'] }}, 'Doanh số': {{ $final[5]['total'] }} },
    { year: {{ $final[6]['day'] }}, 'Doanh số': {{ $final[6]['total'] }} }
  ],
  // The name of the data record attribute that contains x-values.
  xkey: 'year',
  // A list of names of data record attributes that contain y-values.
  ykeys: ['Doanh số'],
  // Labels for the ykeys -- will be displayed when you hover over the
  // chart.
  labels: ['Doanh số']

});

  new Morris.Donut({
  // ID of the element in which to draw the chart.
  element: 'orderchart',
  // Chart data records -- each entry in this array corresponds to a point on
  // the chart.
  data: [
      { label: "Đang chờ", value: {{ $statusCounts["Đang chờ"] ?? 0 }} },
      { label: "Hoàn thành", value: {{ $statusCounts["Hoàn thành"] ?? 0 }} },
      { label: "Huỷ", value: {{ $statusCounts['Đã huỷ'] ?? 0 }} }
    ],
  // Màu sắc từng phần
  colors: ['#FFA500', '#28a745', '#dc3545'],
});
</script>
<script src="assets/js/report.js"></script>
<script src="morris.js-0.5.1/morris.min.js"></script>
@endsection