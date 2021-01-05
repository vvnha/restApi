
@extends('layouts.admin')

@section('title', 'Admin Foods')

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
              <h3>{{$collection}}</h3>
              <p>Tổng số thực đơn</p>
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
      <div class="div1">
        <div class="table-wrapper div2">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Manage <b>Food</b></h2>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                      <th>ID</th>
                      <th>Tên</th>
                      <th>Hình ảnh</th>
                      <th>Giá</th>
                      <th>Đánh giá</th>
                      <th>Parent ID</th>
                      <th>Ngày tạo</th>
                      <th>Edit/Del</th>
                    </tr>
                </thead>
                <tbody>
                     @foreach($foods as $value)
                    <tr>
                      <td>{{$value->foodID}}</td>
                      <td>{{$value->foodName}}</td>
                      <td>
                        <a href="{{$value->img}}">
                          <img src="{{$value->img}}" alt="..." style="height: 60px;width: 80px;"></a>

                      </td>
                      <td>{{number_format($value->price)}}</td>
                      <td>{{$value->rating}}</td>
                      <td>{{$value->parentID}}</td>
                      <td>{{$value->created_at}}</td>
                      <td>
                        <a href="admin/food/edit/{{$value->foodID}}" class="edit open-modal" ><i class="fa fa-pencil-square-o" data-toggle="tooltip" title="Edit"></i></a>
                        <a href="admin/food/delete/{{$value->foodID}}" onclick="return confirm('Delete Food?')" class="delete"><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete"></i></a>
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

<!-- foodID`, `foodName`, `img`, `price`, `rating`, `hits`, `ingres`, `parentID`, `created_at`, `updated_at -->