
@extends('layouts.admin')

@section('title', 'Order Status')

@section('css')
<style type="text/css">
table {
  width: 100%;
  border-collapse: collapse;
}
.tables{
  padding: 15px 1px 0 15px;
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
        <li><a href="admin"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">{{$xacnhan}}</li>
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
            <a href="admin/order/allorder" class="small-box-footer">Thêm menu <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{$hoanthanh}}<sup style="font-size: 20px"></sup></h3>
              <p>Hoàn thành</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="admin/order/success" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{$daxacnhan}}</h3>
              <p>Đã xác nhận</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="admin/order/xacnhan" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{$chuaxacnhan}}</h3>

              <p>Chưa xác nhận</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="admin/order" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col 4 cai tren-->
      </div>
      <!-- <p class="active bg-primary" style="padding: 10px">{{$xacnhan}}</p> -->
       <!--  Hang 2 contents -->
      <!-- /.row -->
      <!-- Main row -->
      <div class="div1">
        <div class="table-wrapper div2">
          <div class="table-title">
              <div class="row">
                  <div class="col-sm-6">
                      <h2>Manage <b>Order</b></h2>
                  </div>
                  <div class="col-sm-6">
                    @if($xacnhan=="all")
                       <a href="admin/order/allorder/day" class="btn btn-success" data-toggle="modal"><span>Xem hôm nay</span></a>
                     @else
                       <a href="admin/order/allorder" class="btn btn-success" data-toggle="modal"><span>Xem tất cả</span></a>
                    @endif          
                  </div>
              </div>
          </div>
          <table class="table table-striped table-hover">
              <thead>
                  <tr>
                    <th>ID</th>
                    <th>userID</th>
                    <th>Tổng tiền</th>
                    <th>Ngày đặt</th>
                    <th>Số bàn</th>
                    <th>Trạng thái</th>
                    <th>DateClick</th>
                    <th>Xem / Hủy</th>
                  </tr>
              </thead>
              <tbody>
                <p hidden="">{{$valueT=0}}</p>
                  @foreach($foods as $value)
                  <tr>
                    <td>{{$value->orderID}}</td>
                    <td>{{$value->userID}}</td>
                    <td>{{number_format($value->total)}} VND</td>
                    <td>{{$value->orderDate}}</td>
                    <td>{{$value->perNum}}</td>
                    <td>{{$value->service}}</td>
                    <td>{{$value->dateClick}}</td>
                    <td>
                        <a href="admin/order/vieworder/{{$value->orderID}}" class="edit open-modal"><i class="fa fa-pencil-square-o" data-toggle="tooltip" title="Xem"></i></a>
                        <a href="admin/order/delete/{{$value->orderID}}" class="delete" ><i class="fa fa-trash-o" title="Xóa" onclick="return confirm('Hủy đơn này?')"></i></a>
                    </td>
                  </tr>
                  @endforeach
              </tbody>
          </table>
        </div>
      </div>
      <div class="active" style="margin-top: 0px;height: 50px;">
        {!! $foods->links() !!}
      </div>
      <!-- /.row (main row) -->
      <!--  /Hang 2 contents -->
    </section>

@endsection

<!-- SELECT `orderID`, `userID`, `total`, `orderDate`, `perNum`, `service`, `dateClick`, `created_at`, `updated_at` FROM `ordertables` WHERE 1 -->