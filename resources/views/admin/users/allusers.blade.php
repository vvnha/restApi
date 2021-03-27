@extends('layouts.admin')

@section('title', 'Admin')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.tables {
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
    <div class="div1">
        <div class="table-wrapper div2">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Manage <b>Accounts</b></h2>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Số ĐT</th>
                        <th>Ngày tạo</th>
                        <th>updated_at</th>
                        <th>Position</th>
                        <th>Khóa</th>
                    </tr>
                </thead>
                <tbody>
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
                                    <option value="1">1 - Admin</option>
                                    <option value="2">2 - Manager</option>
                                    <option value="3">3 - User</option>
                                    <option value="4">4 - Staff</option>
                                    <option value="6">6 - Part-time staff</option>
                                </select>
                                <button type="submit" class="bg-primary small">CẬP NHẬT</button>
                            </form>
                        </td>
                        <td>
                            <a href="admin/account/block/{{$value->id}}" class="delete"
                                onclick="return confirm('Khóa tài khoản này?')"><i class="fa fa-ban" aria-hidden="true"
                                    title="Block"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="active" style="margin-top: 0px;height: 50px;">
        {!! $accounts->links() !!}
    </div>

    <!-- /.row (main row) -->
    <!--  /Hang 2 contents -->
</section>

@endsection