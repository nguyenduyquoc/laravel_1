@extends("admin.layout")
@section("title", "List Product")
@section("content-header")
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 style="color: #2d3748" class="m-0 text-dark right text-right">List Product</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url("/admin/product/add_product")}}">Add new product</a></li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection
@section("main-content")
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Bordered Table</h3>
            <div class="card-tools">
                <form action="{{url("/admin/product/list_product")}}" method="get">
                    <div class="input-group input-group-sm" style="width: 500px;">
                        <input type="number" value="{{app("request")->input("minprice")}}" name="minprice" class="form-control float-right" placeholder="Min_price">
                        <input type="number" value="{{app("request")->input("maxprice")}}" name="maxprice" class="form-control float-right" placeholder="Max_price">
                        <select name="category_id" class="mr-1">
                            <option value="0">Choose category..</option>
                            @foreach($categories as $item)
                                <option @if(app("request")->input("category_id")== $item->id) selected @endif value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
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
                    <th>Thumbnail</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Unit</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Action</th>
                    <th>Action2</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td><img style="width: 70px; height: 70px" src="{{ $item->thumbnail }}" alt=""></td>
                        <td><span class="badge bg-danger">{{ $item->price }}</span></td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->unit }}</td>
                        <td>{{ $item->Category->name }}
                            <span class="badge bg-info">{{$item->Category->Products->count()}}</span>
                        </td>
                        <td>
                            @if($item->status)
                                <span class="badge bg-danger">Active</span>
                            @else
                                <span class="badge bg-success">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-primary" style="background-color: #721c24; color: white" href="{{route("product_edit", ["product"=>$item->id])}}">Edit</a>
                        </td>
                        <td>
                            <form method="post" action="{{route("product_delete", ["product"=>$item->id])}}">
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
            {!! $data->appends(app("request")->input())->links("pagination::bootstrap-4") !!}
{{--            {!! $data->links("pagination::bootstrap-4") !!}--}}
        </div>
    </div>
    <!-- /.card -->

@endsection
