
@extends('layouts.admin')

@section('title', 'Admin Chart')

@section('css')
<style>
.tables{
    padding: 15px 1px 0 15px;
}
table {
  width: 100%;
  border-collapse: collapse;
}
.div1 {
  display: table;
  table-layout: fixed;
  width: 100%;
}

.div2 {
  display: table-cell;
  overflow-x: auto;
  width: 100%;
}
div.doanhthu {
  text-align: center;
  margin-left: 20px;
}
</style>
 <link rel="stylesheet" href="public/css/table.css">
@endsection

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">30 days</li>
      </ol>
    </section>
  <!-- /.content-wrapper -->

     <!-- Main content -->
    <section class="content">


       <!--  Hang 2 contents -->
      <!-- /.row -->
      <!-- Main row -->
      <div class="div1">
        <div class="table-wrapper div2">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Doanh Thu <b>Nhà Hàng</b></h2>
                    </div>
                    <div class="col-sm-6" data-toggle="modal">
                      <form method="POST" action="{{url('admin/chart')}}" >
                          {{ csrf_field() }}
                          <div class="row" style="margin: 5px 0 0;">
                          <p class="col-sm-6"></p>
                          <input class="col-sm-5" type="date" class="form-control" id="dateS" name="dateS" value="{{$dateS}}" style="color: black;border-radius: 5px 5px 5px 5px;">
                          <button type="submit" class="col-sm-1" style="background: #39a8dd; color: white;">OK </button>   
                        </div>  
                      </form>   
                    </div>
                </div>
            </div>
            <div class="container">
              <div class="doanhthu">
                <h3>Thống kê doanh thu từ {{$dateS}}</h3>
              </div>
              <canvas id="myChart"></canvas>
            </div>
        </div>
      </div>
      
     
      <!-- /.row (main row) -->
      <!--  /Hang 2 contents -->
    </section>

@endsection

@section('scripts')
<script src="public/js/Chart.min.js"></script>

<script>
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!!json_encode($lb)!!},
        datasets: [{
             label: ['Doanh thu'],
            data: {!!json_encode($dt)!!} ,
            backgroundColor: {!!json_encode($cl)!!},
            borderColor:{!!json_encode($cl)!!},
            borderWidth: 2
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>
@endsection