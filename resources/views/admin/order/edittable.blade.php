@extends('layouts.admin')

@section('title', 'Admin Chart')

@section('css')
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
<section class="content-header">
    <h1>
        Dashboard
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">7 days</li>
    </ol>
</section>
<section class="content">
    <div class="div1">
        <div class="table-wrapper div2">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Doanh Thu <b>Hotel</b></h2>
                    </div>
                    <div class="col-sm-6">
                        <a href="admin/year" class="btn btn-success" data-toggle="modal"><span>Trong 30 Ngày</span></a>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="doanhthu">
                    <h3>Chỉnh sửa bàn ăn</h3>
                    @if(isset($messages))
                    <p style="color:red">{{$messages}}</p>
                    @endif
                    <!-- <p>{{$data->orderID}}</p>
                    <p>{{$data->userID}}</p>
                    <p>{{$data->dateClick}}</p> -->
                    <form action="admin/order/vieworder/searchtable" method='POST'>
                        {{ csrf_field() }}
                        <label for="birthdaytime">Đặt ngày:</label>
                        <input type="text" name="id" value='{{$data->orderID}}' hidden>
                        <input type="datetime-local" name="orderDate" value='{{$dateOrder}}'>
                        <input type="submit">
                    </form>
                    <p>So ban: {{$data->perNum}}</p>
                    <p>Chọn lại ngày giờ</p>
                    <form action="admin/order/vieworder/searchtable" method='POST'>
                        {{ csrf_field() }}
                        <label for="birthdaytime">Tìm kiếm thời gian ăn:</label>
                        <input type="text" name="id" value='{{$data->orderID}}' hidden>
                        <input type="datetime-local" name="datetime" value='{{$dateOrder}}'>
                        <input type="submit">
                    </form>
                    <form action="admin/order/vieworder/searchtable" method='POST'>
                        {{ csrf_field() }}
                        <label for="birthdaytime">Tìm kiếm bàn ăn:</label>
                        <input type="text" name="id" value='{{$data->orderID}}' hidden>
                        <input type="datetime-local" name="datetime" value='{{$dateOrder}}' hidden>
                        <input type="text" name="numberTable" value='{{$data->perNum}}'>
                        <input type="submit">
                    </form>

                    @if( isset($orderedLabel))
                    <ul class="list-group list-group-horizontal">
                        <p> Bàn đã đặt là: {{$orderedLabel}}</p>
                        @foreach($ordered as $value)

                        <li class="list-group-item col-lg-2 btn btn-success" style="margin: 0px 10px 10px 0px;">Bàn số
                            {{$value}}</li>

                        @endforeach
                        @endif
                    </ul><br>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection
<!-- "orderID" => 2
"userID" => 2
"total" => 6000000.0
"orderDate" => "2020-11-26 10:44:52"
"perNum" => "2,3"
"service" => "1"
"dateClick" => "2020-11-26 10:44:52"
"created_at" => null
"updated_at" => "2021-04-02 21:36:49" -->