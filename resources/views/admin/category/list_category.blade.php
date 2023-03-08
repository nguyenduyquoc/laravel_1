@extends("admin.layout")
@section("title", "List Category")
@section("content-header")
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 style="color: #2d3748" class="m-0 text-dark right text-right">List Category</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url("/admin/category/add_category")}}">Add new category</a></li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection
@section("main-content")
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Bordered Table</h3>
            <div class="card-tools">
                <form action="{{url("/admin/category/list_category")}}" method="get">
                    <div class="input-group input-group-sm" style="width: 500px;">
                        <input type="text" value="{{app("request")->input("search")}}" name="search" class="form-control float-right" placeholder="Search">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th style="width: 10px">Id</th>
                    <th>Name</th>
                    <th>Icon</th>
                    <th>Status</th>
                    <th>Action1</th>
                    <th>Action2</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data_categories as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td><img style="width: 70px; height: 70px" src="{{ $item->icon }}" alt=""></td>
                        <td>
                            @if($item->status)
                                <span class="badge bg-danger">Active</span>
                            @else
                                <span class="badge bg-success">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-primary" style="background-color: #721c24; color: white" href="{{route("category_edit", ["category"=>$item->id])}}">Edit</a>
                        </td>
                        <td>
                            <form method="post" action="{{route("category_delete", ["category"=>$item->id])}}">
                                @method("DELETE")
                                @csrf
                                <button type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa không!')"
                                        class="btn btn-outline-warning">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">

            {!! $data_categories->appends(app("request")->input())->links("pagination::bootstrap-4") !!}

        </div>
    </div>
    <!-- /.card -->

@endsection

