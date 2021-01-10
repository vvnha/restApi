
@extends('layouts.admin')

@section('title', 'Admin')

@section('sidebar')
   <!--  <p>sidebar</p> -->
@endsection
@section('css')
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
        <li class="active">Dashboard</li>
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
              <h3>150</h3>

              <p>New Orders</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>53<sup style="font-size: 20px">%</sup></h3>

              <p>Bounce Rate</p>
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
              <h3>44</h3>

              <p>User Registrations</p>
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
              <h3>65</h3>

              <p>Unique Visitors</p>
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
      <div class="table-wrapper ">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-6">
                    <h2>Manage <b>Order</b></h2>
                </div>
                <div class="col-sm-6" data-toggle="modal">
                  <form action="{{url('admin')}}" method="POST">
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
        <div class="row" style="padding: 15px">

        <ul class="list-group list-group-horizontal">
          @foreach($sb as $value)
          <?php 
            if ($datas=="1") {
              $result = explode( ',', $value );
              $counts = count($result);
              echo "<a href='admin/order/vieworder/".$result[1]."'><li class='list-group-item col-lg-2 ' style='background-color: #dd4b39;color: #f9f9f9;margin: 0px 10px 10px 0px;''>Bàn số: ";
                 echo $result[0].", Ngày ".$result[2];
              echo "</li></a>";
            }
          ?>
         <!--  <li class="list-group-item col-lg-2" style="margin: 0px 10px 10px 0px;">Bàn số {{$value}}</li> -->
          @endforeach
        </ul>
      </div>
      </div>
      
      <!-- /.row (main row) -->
      <!--  /Hang 2 contents -->

    </section>

@endsection