@extends('layouts.admin')

@section('title', 'Salary')

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
    <!-- <div class="active bg-primary" style="padding: 10px">
        <p>OK</p>
        <p>OK</p>
        <p>OK</p>
    </div> -->

    <div class="div1">
        <div class="table-wrapper div2">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Manage <b>Food</b></h2>
                    </div>
                    <div class="col-sm-6">
                        <a onclick="event.preventDefault();addTaskForm();" href="#" class="btn btn-success"
                            data-toggle="modal"><span>Thêm</span></a>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Loại lương</th>
                        <th>Hệ số</th>
                        <th>Giờ làm</th>
                        <th>Giá</th>
                        <th>Ghi chú</th>
                        <th>Sửa / Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $value)
                    <tr>
                        <td>{{$value->id}}</td>
                        <td>{{$value->type}}</td>
                        <td>{{$value->coeficient}}</td>
                        <td>{{$value->hour}}</td>
                        <td>{{$value->salary}}</td>
                        <td>{{$value->note}}</td>
                        <td>
                            <a onclick="event.preventDefault();editTaskForm({{$value->id}});" href="#"
                                class="edit open-modal" data-toggle="modal" value="1"><i class="fa fa-pencil-square-o"
                                    data-toggle="tooltip" title="Edit"></i></a>

                            <a onclick="event.preventDefault();deleteTaskForm({{$value->id}});" href="#" class="delete"
                                data-toggle="modal"><i class="fa fa-trash-o" data-toggle="tooltip"
                                    title="Delete"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @include('admin.salary.partials.task_add')
    @include('admin.salary.partials.task_edit')
    @include('admin.salary.partials.task_delete')

</section>

@endsection

@section('scripts')
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="public/js/salary.js"></script>
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
