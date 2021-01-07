
@extends('layouts.admin')

@section('title', 'Add Foods')

@section('css')
<style>
.add {
  border: 1px solid blue;
  text-align: left;
}
.ds{
  border: none;
  color: blue;
  padding: 15px 32px;
  font-size: 35px;
}
</style>

@endsection

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Food
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="admin"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Edit food</li>
      </ol>
    </section>
  <!-- /.content-wrapper -->

     <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="container">
          <p class="ds btn btn-lg btn-block" style="font-size: 35px;">Sửa Đồ Ăn</p>
          <div>
            @if ($errors->any())
             <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
                </ul>
            </div>    
            @endif
          </div>

          @if (\Session::has('success'))
            <div class="alert alert-success">
                <ul>
                    <li>{!! \Session::get('success') !!}</li>
                </ul>
            </div>
          @endif

           <form  action="{{url('admin/food/edit/' . $food->foodID)}}" method="POST" style="margin-bottom: 100px;margin-right: 60px;margin-left: 60px;" >
                    {{ csrf_field() }}
                <div class="form-group">
                  <label for="formGroupExampleInput">Tên</label>
                  <input type="text" class="form-control"   name="name" required value="{{$food->foodName}}">
                </div>

                <div class="row form-group">
                  <div class="col-md-6">
                      <label for="formGroupExampleInput2">Giá</label>
                      <input type="text" class="form-control"   name="price" required value="{{$food->price}}">
                  </div>
                  <div class="col-md-6">
                    <label for="formGroupExampleInput2">Loại</label></br>
                    <select class="form-control custom-select custom-select-lg mb-3" name="parentID">
                      <option selected value="{{$food->parentID}}" >{{$food->parentID}}</option>

                      <option value="1">1 - Đồ ăn</option>
                      <option value="2">2 - Đồ uống</option>
                      <option value="3">3 - Khác</option>
                    </select>
                    <!-- <input type="text" class="form-control" placeholder="First name"> -->
                  </div>
                </div>

                <div class="form-group">
                  <label for="formGroupExampleInput2">Đặc biệt</label>
                  <input type="text" class="form-control" name="hits" required value="{{$food->hits}}">
                </div>

                <div class="form-group">
                  <label for="formGroupExampleInput2">Thành phần</label>
                  <input type="text" class="form-control" name="ingres" required value="{{$food->ingres}}">
                </div>
               
                <button class="btn btn-primary" type="submit">Cập nhật</button>
                <a href="admin/food"><button class="btn btn-danger" type="button" >HỦY </button></a>
            </form>

            <form action="{{url('admin/food/edita/upload/' . $food->foodID)}}" method="POST" style="margin-bottom: 100px;margin-right: 60px;margin-left: 60px;" enctype="multipart/form-data">
                {{ csrf_field() }}
               <div class="form-group">
                <label for="formGroupExampleInput2">Link: 
                   <a href="{{$food->img}}">{{$food->img}}</a></br>
                   <img src="{{$food->img}}" style="height: 300px;width: 400px;">
                </label></br>
                <label for="formGroupExampleInput2">Thay ảnh</label>
                <input type="file" name="file" class="form-control" required="true">
                <button class="btn btn-primary" type="submit" style="margin-top: 10px;">Tải lên</button>
              </div>
            </form>

        </div>
      </div>
    </section>

@endsection

<!-- foodID`, `foodName`, `img`, `price`, `rating`, `hits`, `ingres`, `parentID`, `created_at`, `updated_at -->