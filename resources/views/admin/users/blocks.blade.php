
@extends('layouts.admin')

@section('title', 'Block')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
        Dashboard Block
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Admin</a></li>
        <li class="active">Block</li>
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
              <h3>{{$all}}</h3>
              <p>Tổng số tài khoản</p>
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
              <h3>{{$use}}<sup style="font-size: 20px"></sup></h3>
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
              <h3>{{$manage}}</h3>
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
              <h3>{{$staff}}</h3>

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
            <th>Tên</th>
            <th>Email</th>
            <th>Số ĐT</th>
            <th>Ngày tạo</th>
            <th>updated_at</th>
            <th>Position</th>
          </tr>
          @foreach($accounts as $value)
          <tr>
            <td>{{$value->id}}</td>
            <td>{{$value->name}}</td>
            <td>{{$value->email}}</td>
            <td>{{$value->phone}}</td>
            <td>{{$value->created_at}}</td>
            <td>{{$value->updated_at}}</td>
            <td>
              <form action="{{url('admin/account/position')}}" method="POST">
                {{ csrf_field() }}
                <input type="" name="id" hidden value="{{$value->id}}">
                <select name="positionID" class="bg-green">
                  <option value="{{$value->positionID}}">{{$value->positionID}}</option>
                  <option value="1">----</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                </select>
                <button type="submit" class="bg-primary small">CẬP NHẬT</button>
              </form>
         <!--      <a href="admin/account/edit/{{$value->id}}" class="fa fa-pencil-square-o bg-warning"></a> /  -->
            </td>
          </tr>
          @endforeach
          </table>
      </div>
      <!-- /.row (main row) -->
      <!--  /Hang 2 contents -->
    </section>

@endsection
