<form action="{{url('admin/account/searchuser')}}" method="get" class="sidebar-form" style={margin-left:100px,
    margin-right:100px}>
    {{ csrf_field()}}
    <div class="input-group">
        <input type="text" name="gmail" class="form-control" placeholder="Search user...">
        <span class="input-group-btn">
            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
            </button>
        </span>
    </div>
</form>