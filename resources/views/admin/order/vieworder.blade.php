
@extends('layouts.admin')

@section('title', 'All orders')

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
    <section class="content">

       <!--  Hang 2 contents -->
      <!-- /.row -->
      <!-- Main row -->
      <div class="active bg-primary" style="padding: 10px">
        <p class="active"> Tên khách hàng: {{$userss->name}}</p>
        <p class="active"> Số điện thoại: {{$userss->phone}}</p>
        <p class="active"> Ngày đặt: {{$giodat}}</p>
        <p class="active"> Đặt ngày: {{$datngay}}</p>
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
      </div>
      
      <div class="row tables div1">
        <div class="div2">
         <table id="customers">
          <tr>
            <th>STT</th>
            <th>Tên</th>
            <th>Số lượng</th>
            <th>Giá</th>
            <th>Sửa / Xóa</th>
          </tr>
          @foreach($foods as $value)
          <tr>
            <td>{{$stt+=1}}</td>
            <td>{{$value->foodName}}</td>
            <td>{{$value->qty}}</td>
            <td>{{number_format($value->price)}}</td>
             <td>
              <a href="admin/order/editdetail/{{$value->detailID}}" class="fa fa-pencil-square-o bg-warning"></a> / 
              <a href="admin/order/deldetail/{{$value->detailID}}" class="fa fa-trash bg-red bg-warning"></a>
            </td>
          </tr>
          @endforeach
          </table>
        </div>
      </div>
      <div class="active" style="padding: 10px">
        <p class="active" style="font-size: 16px;color:#0a51f1"> Thành tiền: {{number_format($total)}} VND</p> 
         <form action="{{url('admin/order/vieworder/editservice')}}" method="POST">
          {{ csrf_field() }}
          <input name="id" hidden value="{{$id}}">
          <input name="service" hidden value="2">
          <button type="submit" class="btn btn-success" style="float: left;">Thanh toán</button>
        </form>

        <form action="{{url('admin/order/vieworder/editservice')}}" method="POST">
          {{ csrf_field() }}
          <input name="id" hidden value="{{$id}}">
          <input name="service" hidden value="3">
          <button type="submit" class="btn btn-danger" style="float: left;margin-left: 10px;">Hủy</button>
        </form>
      </div>

    </section>
    
@endsection

<!-- SELECT `orderID`, `userID`, `total`, `orderDate`, `perNum`, `service`, `dateClick`, `created_at`, `updated_at` FROM `ordertables` WHERE 1 -->