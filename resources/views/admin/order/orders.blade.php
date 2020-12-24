
@extends('layouts.admin')

@section('title', 'All orders')

@section('css')
<style>
.tables{
    padding: 15px 15px 0 15px;
}
#customers {
  font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
  border-collapse: collapse;
  width: 100%;

}
#customers td, #customers th {
/*  border: 3px solid #32383e;*/
  padding: 8px;
  border-top: 1px solid #dee2e6;
  
}
#customers tr:nth-child(even){
  background-color: #6c757d;
  color: #fff;
}
#customers tr:hover {background-color: #17a2b8;}
#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #212529;
  color: white;
}

</style>

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
        <li class="active">Hoàn thành</li>
      </ol>
    </section>
  <!-- /.content-wrapper -->

     <!-- Main content -->
    <section class="content">

      <!-- Small boxes (Stat box)4 cai tren -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{$collection}}</h3>
              <p>Tổng số đặt hàng</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="admin/food/addfood" class="small-box-footer">Thêm menu <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>10<sup style="font-size: 20px"></sup></h3>
              <p>Người dùng</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>10</h3>
              <p>Nhân viên</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>10</h3>

              <p>Đầu bếp</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col 4 cai tren-->
      </div>

       <!--  Hang 2 contents -->
      <!-- /.row -->
      <!-- Main row -->
      <div class="row tables">

         <table id="customers">
          <tr>
            <th>ID</th>
            <th>userID</th>
            <th>Tổng tiền</th>
            <th>orderDate</th>
            <th>perNum</th>
            <th>service</th>
            <th>dateClick</th>
           <!--  <th>Edit/Del</th> -->

          </tr>
          @foreach($foods as $value)
          <tr>
            <td>{{$value->orderID}}</td>
            <td>{{$value->userID}}</td>
            <td>{{$value->total}}</td>
            <td>{{$value->orderDate}}</td>
            <td>{{$value->perNum}}</td>
            <td>{{$value->service}}</td>
            <td>{{$value->dateClick}}</td>
            <!-- <td>
              <a href="admin/order/edit/{{$value->orderID}}" class="fa fa-pencil-square-o bg-warning"></a> / 
              <a href="admin/order/delete/{{$value->orderID}}" onclick="return confirm('Delete Food?')" class="fa fa-trash bg-red"></a>
            </td> -->
          </tr>
          @endforeach
          </table>
      </div>
      <!-- /.row (main row) -->
      <!--  /Hang 2 contents -->
    </section>

@endsection

<!-- SELECT `orderID`, `userID`, `total`, `orderDate`, `perNum`, `service`, `dateClick`, `created_at`, `updated_at` FROM `ordertables` WHERE 1 -->