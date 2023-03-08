@extends("admin.layout")
@section("title", "List Orders")
@section("content-header")
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 style="color: #2d3748" class="m-0 text-dark right text-right">List Orders</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection
@section("main-content")
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Bordered Table</h3>
            <div class="card-tools">
{{--                <form action="{{url("/admin/category/list_category")}}" method="get">--}}
{{--                    <div class="input-group input-group-sm" style="width: 500px;">--}}
{{--                        <input type="text" value="{{app("request")->input("search")}}" name="search" class="form-control float-right" placeholder="Search">--}}
{{--                        <div class="input-group-append">--}}
{{--                            <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </form>--}}
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th style="width: 10px">Id</th>
                    <th>Shipping Address</th>
                    <th>Customer Telephone</th>
                    <th>Grand Total</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data_order as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->shipping_address }}</td>
                        <td><span class="badge bg-danger">{{ $item->customer_tel }}</span></td>
                        <td><span class="badge bg-danger">{{ $item->grand_total }}</span></td>
                        <td>
                            @switch($item->status)
                                @case(0)
                                    <span class="badge bg-gray">Order Placed</span>
                                    @break
                                @case(1)
                                    <span class="badge bg-cyan">Payment Received</span>
                                    @break
                                @case(2)
                                    <span class="badge bg-yellow">Order Processing</span>
                                    @break
                                @case(3)
                                    <span class="badge bg-blue">Shipped</span>
                                    @break
                                @case(4)
                                    <span class="badge bg-success">Delivered</span>
                                    @break
                                @case(5)
                                    <span class="badge bg-dark">Cancelled</span>
                                    @break
                                @case(6)
                                    <span class="badge bg-orange">On Hold</span>
                                    @break
                                @default
                                    <span class="badge bg-success">Unidentified</span>
                            @endswitch
                        </td>
                        <td>
                            <a class="btn btn-primary" style="background-color: #721c24; color: white" href="{{route("detail", ["order"=>$item->id])}}">Detail</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">

{{--            {!! $data_categories->appends(app("request")->input())->links("pagination::bootstrap-4") !!}--}}
            {!! $data_order->links("pagination::bootstrap-4") !!}
        </div>
    </div>
    <!-- /.card -->

@endsection

