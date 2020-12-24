
@extends('layouts.admin')

@section('title', 'Add Foods')

@section('css')
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
<!-- foodID`, `foodName`, `img`, `price`, `rating`, `hits`, `ingres`, `parentID`, `created_at`, `updated_at -->
          <p class="ds btn btn-lg btn-block" style="font-size: 35px;">Sửa Đồ Ăn</p>
          <div>
            @if ($errors->any())
             <div class="alert alert-danger content-header">
                <ul>
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
                </ul>
            </div>    
            @endif
          </div>

          @if (\Session::has('success'))
            <div class="alert alert-success content-header">
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

                      <option value="1"  >1 - Đồ ăn</option>
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
                   <img src="{{$food->img}}">
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