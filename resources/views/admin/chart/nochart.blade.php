
@extends('layouts.admin')

@section('title', 'Admin Chart')

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
                        <a  href="admin/year" class="btn btn-success" data-toggle="modal"><span>Trong 7 Ngày</span></a>                   
                    </div>
                </div>
            </div>

            <div class="container">
              <div class="doanhthu">
                <h3>Không có dữ liệu thống kê</h3>
              </div>
            </div>
        </div>
      </div>
    </section>
@endsection
