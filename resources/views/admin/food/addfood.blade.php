
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
        Add Food
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="admin"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Add food</li>
      </ol>
    </section>
  <!-- /.content-wrapper -->

     <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="container">
<!-- foodID`, `foodName`, `img`, `price`, `rating`, `hits`, `ingres`, `parentID`, `created_at`, `updated_at -->
          <p class="ds btn btn-lg btn-block" style="font-size: 35px;">Thêm Đồ Ăn</p>
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

           <form  action="{{url('admin/food/addfood1')}}" method="POST" enctype="multipart/form-data" style="margin-bottom: 100px;margin-right: 60px;margin-left: 60px;" >
                    {{ csrf_field() }}
                <div class="form-group">
                  <label for="formGroupExampleInput">Tên</label>
                  <input type="text" class="form-control"   name="name" required>
                </div>

                <div class="row form-group">
                  <div class="col-md-6">
                      <label for="formGroupExampleInput2">Giá</label>
                      <input type="text" class="form-control"   name="price" required>
                  </div>
                  <div class="col-md-6">
                    <label for="formGroupExampleInput2">Loại</label></br>
                    <select class="form-control custom-select custom-select-lg mb-3" name="parentID">
                      <option selected value="1"  >1 - Đồ ăn</option>
                      <option value="2">2 - Đồ uống</option>
                      <option value="3">3 - Khác</option>
                    </select>
                    <!-- <input type="text" class="form-control" placeholder="First name"> -->
                  </div>
                </div>

                <div class="form-group">
                  <label for="formGroupExampleInput2">Đặc biệt</label>
                  <input type="text" class="form-control" name="hits" required>
                </div>

                <div class="form-group">
                  <label for="formGroupExampleInput2">Thành phần</label>
                  <input type="text" class="form-control" name="ingres" required>
                </div>

                 <div class="form-group">
                  <label for="formGroupExampleInput2">Chọn ảnh</label>
                  <input type="file" name="file" class="form-control" required="true">
                </div>
               
                <button class="btn btn-primary" type="submit">THÊM NGAY</button>
                <a href="admin/food"><button class="btn btn-danger btn-sm" type="button" >HỦY </button></a>
            </form>



        </div>
      </div>
    </section>

@endsection

<!-- foodID`, `foodName`, `img`, `price`, `rating`, `hits`, `ingres`, `parentID`, `created_at`, `updated_at -->