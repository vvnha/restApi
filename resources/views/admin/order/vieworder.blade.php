@extends('layouts.admin')

@section('title', 'All orders')

@section('css')
<style type="text/css">
table {
    width: 100%;
    border-collapse: collapse;
}

.tables {
    padding: 15px 1px 0 15px;
}

.div1 {
    display: table;
    table-layout: fixed;
    width: 100%;
    margin-bottom: 10px;
    margin-top: 10px;
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
        Đơn đặt hàng
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">View</li>
    </ol>
</section>
<!-- /.content-wrapper -->

<!-- Main content -->
<section class="content" style="padding-bottom: 10px;">

    <!--  Hang 2 contents -->
    <!-- /.row -->
    <!-- Main row -->
    <div class="active bg-primary" style="padding: 10px">
        <p class="active"> Tên khách hàng: {{$userss->name}}</p>
        <p class="active"> Số điện thoại: {{$userss->phone}}</p>
        <p class="active"> Ngày đặt: {{$giodat}}</p>
        <p class="active"> Đặt ngày: {{$datngay}}</p>
        <p class="active"> Số bàn: {{$perNum}}</p>
        <!-- <p class="active"> Gio an: {{$eatTime->eatTime}}</p> -->

        <form action="{{url('admin/order/vieworder/edittimeeat')}}" method="POST">
            {{ csrf_field() }}
            <input type="" name="id" hidden value="{{$eatTime->id}}">
            <select name="eatTime" class="bg-green">
                <option value="{{$eatTime->eatTime}}">{{$eatTime->eatTime}}</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
            <button type="submit" class="bg-primary small">CẬP NHẬT GIỜ ĂN</button>
        </form>

        <form action="{{url('admin/order/vieworder/editservice')}}" method="POST">
            {{ csrf_field() }}
            <input type="" name="id" hidden value="{{$id}}">
            <select name="service" class="bg-green">
                <option value="{{$service}}">{{$service}}</option>
                <option value="0">0 - Chưa xác nhận</option>
                <option value="1">1 - Đã xác nhận</option>
                <option value="2">2 - Hoàn thành</option>
                <option value="3">3 - Đã hủy</option>
            </select>
            <button type="submit" class="bg-primary small">CẬP NHẬT TRẠNG THÁI</button>
        </form>
        <a href="admin/order/vieworder/edittable/{{$id}}" class="text-success"><b>Thay đổi ngày giờ, bàn
                ăn</b></a><br /><br />
    </div>

    <div class="div1">
        <div class="table-wrapper div2">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Manage <b>Food</b></h2>
                    </div>
                    <div class="col-sm-6">
                        <a onclick="event.preventDefault();addTaskForm();" href="#" class="btn btn-success"
                            data-toggle="modal"><span>Add New Food</span></a>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Sửa / Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    <p hidden="">{{$valueT=0}}</p>
                    @foreach($foods as $value)
                    <tr>
                        <td>{{$stt+=1}}</td>
                        <td>{{$value->foodName}}</td>
                        <td>{{$value->qty}}</td>
                        <td>{{number_format($prices = $value->price*$value->qty)}} vnd</td>
                        <p hidden="">{{$valueT+=$prices}}</p>
                        <td>
                            <a onclick="event.preventDefault();editTaskForm({{$value->detailID}});" href="#"
                                class="edit open-modal" data-toggle="modal" value="{{$value->detailID}}"><i
                                    class="fa fa-pencil-square-o" data-toggle="tooltip" title="Edit"></i></a>

                            <a onclick="event.preventDefault();deleteTaskForm({{$value->detailID}});" href="#"
                                class="delete" data-toggle="modal"><i class="fa fa-trash-o" data-toggle="tooltip"
                                    title="Delete"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @include('admin.order.partials.task_add')
    @include('admin.order.partials.task_edit')
    @include('admin.order.partials.task_delete')

    <div class="active">
        @if (\Session::has('success'))
        <div class="alert alert-success">
            <ul>
                <li>{!! \Session::get('success') !!}</li>
            </ul>
        </div>
        @endif
        <p class="active" style="font-size: 16px;color:#0a51f1"> Thành tiền: {{number_format($valueT)}} VND</p>
        <div style="height: 20px;margin-bottom: 30px;">
            <form action="{{url('admin/order/vieworder/thanhtoan')}}" method="POST">
                {{ csrf_field() }}
                <input name="id" hidden value="{{$id}}">
                <input name="tongtien" hidden value="{{$valueT}}">
                <input name="service" hidden value="2">
                <button type="submit" class="btn btn-success" style="float: left;"
                    onclick="return confirm('Xác nhận thanh toán?')">Thanh toán</button>
            </form>

            <form action="{{url('admin/order/vieworder/editservice')}}" method="POST">
                {{ csrf_field() }}
                <input name="id" hidden value="{{$id}}">
                <input name="service" hidden value="3">
                <button type="submit" class="btn btn-danger" style="float: left;margin-left: 10px;"
                    onclick="return confirm('Hủy đơn này?')">Hủy đơn này</button>
            </form>
        </div>
        <a href="admin/printorder/{{$id}}" target="_blank" class="text-success"><b>In hóa đơn</b></a><br /><br />
    </div>
</section>

@endsection

@section('scripts')
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="public/js/tasks.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('.btn-number').click(function(e) {
        e.preventDefault();
        var fieldName = $(this).attr('data-field');
        var type = $(this).attr('data-type');
        var input = $("input[name='" + fieldName + "']");
        var currentVal = parseInt(input.val());
        if (!isNaN(currentVal)) {
            if (type == 'minus') {
                var minValue = parseInt(input.attr('min'));
                if (!minValue) minValue = 1;
                if (currentVal > minValue) {
                    input.val(currentVal - 1).change();
                }
                if (parseInt(input.val()) == minValue) {
                    $(this).attr('', true);
                }
            } else if (type == 'plus') {
                var maxValue = parseInt(input.attr('max'));
                if (!maxValue) maxValue = 10;
                if (currentVal < maxValue) {
                    input.val(currentVal + 1).change();
                }
                if (parseInt(input.val()) == maxValue) {
                    $(this).attr('', true);
                }
            }
        } else {
            input.val(0);
        }
    });
});
</script>
@endsection