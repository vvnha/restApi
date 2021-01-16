
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
                        <h2>Phản hồi <b>Hotel</b></h2>
                    </div>
                </div>
            </div>
              <table class="table table-striped table-hover">
                <thead>
                    <tr>
                      <th>ID</th>
                      <th>User</th>
                      <th>Nội dung</th>
                      <th>Thời gian</th>
                    </tr>
                </thead>
                <tbody>
                     @foreach($contacts as $value)
                    <tr>
                      <td>{{$value->contactID}}</td>
                      <td>{{$value->userID}}</td>
                      <td>{{$value->mess}}</td>
                      <td>{{$value->created_at}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
      </div>
      <div class="active" style="margin-top: 0px;height: 50px;">
        {!! $contacts->links() !!}
      </div>
    </section>
@endsection
