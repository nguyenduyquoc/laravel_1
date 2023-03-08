@extends("admin.layout")

@section("title", "Order Detail")

@section("before_css")
    <style>
        .track {
            position: relative;
            background-color: #ddd;
            height: 7px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            margin-bottom: 4rem;
            margin-top: 2rem;
        }
        .track .step {
            -webkit-box-flex: 1;
            -ms-flex-positive: 1;
            flex-grow: 1;
            width: 25%;
            margin-top: -18px;
            text-align: center;
            position: relative;
        }
        .track .step.active:before {
            background:
                @switch($order->status)
                    @case(0)
                        #6c757d
                        @break
                    @case(1)
                        #17a2b8
                        @break
                    @case(2)
                        #ffc107
                        @break
                    @case(3)
                        #007bff
                        @break
                    @case(4)
                        #28a745
                        @break
                    @case(5)
                        #343a40
                        @break
                    @case(6)
                        #fd7e14
                        @break
                    @default
                        #28a745
        @endswitch;
        }
        .track .step::before {
            height: 7px;
            position: absolute;
            content: "";
            width: 100%;
            left: 0;
            top: 18px;
        }
        .track .step.active .icon {
            background:
                @switch($order->status)
                    @case(0)
                        #6c757d
                        @break
                    @case(1)
                        #17a2b8
                        @break
                    @case(2)
                        #ffc107
                        @break
                    @case(3)
                        #007bff
                        @break
                    @case(4)
                        #28a745
                        @break
                    @case(5)
                        #343a40
                        @break
                    @case(6)
                        #fd7e14
                        @break
                    @default
                        #28a745
        @endswitch;
            color: #fff;
        }
        .track .icon {
            display: inline-block;
            width: 40px;
            height: 40px;
            line-height: 40px;
            position: relative;
            border-radius: 100%;
            background: #ddd;
        }
        .track .step.active .text {
            font-weight: 400;
            color: #000;
        }
        .track .text {
            display: block;
            margin-top: 7px;
        }
    </style>
@endsection

@section("content-header")
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Order Detail</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Order</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
@endsection

@section("main-content")
    <!-- Main content -->
    <div class="invoice p-3 mb-3">
        <!-- title row -->
        <div class="row">
            <div class="col-12">
                <h4>
                    <i class="fas fa-tag"></i> Order # {{ $order->id }}
                    <small class="float-right">
                        @switch($order->status)
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
                    </small>
                </h4>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <table class="mt-2 mb-4">
            <tr>
                <th style="width:40%">Order date:</th>
                <td>{{$order->created_at}}</td>
            </tr>
            <tr>
                <th>Shipping address:</th>
                <td>{{$order->shipping_address}}</td>
            </tr>
            <tr>
                <th>Customer phone number:</th>
                <td>{{$order->customer_tel}}</td>
            </tr>
        </table>

        <!-- Table row -->
        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-striped mb-0">
                    <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order->Products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->pivot->quantity }}</td>
                            <td>{{ number_format($product->pivot->price, 0) }}</td>
                            <td>{{ number_format($product->pivot->quantity * $product->pivot->price, 0) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>Grand Total:</th>
                    <th>{{ number_format($order->grand_total, 0) }}</th>
                    </tfoot>
                </table>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        {{--        <div class="row">--}}
        {{--            <!-- accepted payments column -->--}}
        {{--            <div class="col-6">--}}
        {{--                <p class="lead">Payment Methods:</p>--}}
        {{--                <img src="/admin/dist/img/credit/visa.png" alt="Visa">--}}
        {{--                <img src="/admin/dist/img/credit/mastercard.png" alt="Mastercard">--}}
        {{--                <img src="/admin/dist/img/credit/american-express.png" alt="American Express">--}}
        {{--                <img src="/admin/dist/img/credit/paypal2.png" alt="Paypal">--}}

        {{--                <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">--}}
        {{--                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem--}}
        {{--                    plugg--}}
        {{--                    dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.--}}
        {{--                </p>--}}
        {{--            </div>--}}
        {{--            <!-- /.col -->--}}
        {{--            <div class="col-6">--}}
        {{--                <p class="lead">Amount Due 2/22/2014</p>--}}

        {{--                <div class="table-responsive">--}}
        {{--                    <table class="table">--}}
        {{--                        <tr>--}}
        {{--                            <th style="width:50%">Subtotal:</th>--}}
        {{--                            <td>$250.30</td>--}}
        {{--                        </tr>--}}
        {{--                        <tr>--}}
        {{--                            <th>Tax (9.3%)</th>--}}
        {{--                            <td>$10.34</td>--}}
        {{--                        </tr>--}}
        {{--                        <tr>--}}
        {{--                            <th>Shipping:</th>--}}
        {{--                            <td>$5.80</td>--}}
        {{--                        </tr>--}}
        {{--                        <tr>--}}
        {{--                            <th>Total:</th>--}}
        {{--                            <td>$265.24</td>--}}
        {{--                        </tr>--}}
        {{--                    </table>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--            <!-- /.col -->--}}
        {{--        </div>--}}
        {{--        <!-- /.row -->--}}

        @if($order->status < 5)
            <div class="track">
                <div class="step @if($order->status >= 0) active @endif">
                    <span class="icon"> <i class="fas fa-clipboard-check"></i> </span>
                    <span class="text"> Order Placed </span>
                </div>
                <div class="step @if($order->status >= 1) active @endif">
                    <span class="icon"> <i class="fas fa-money-check"></i> </span>
                    <span class="text"> Payment Received </span>
                </div>
                <div class="step @if($order->status >= 2) active @endif">
                    <span class="icon"> <i class="fas fa-truck-loading"></i> </span>
                    <span class="text"> Order Processing </span>
                </div>
                <div class="step @if($order->status >= 3) active @endif">
                    <span class="icon"> <i class="fa fa-truck"></i> </span>
                    <span class="text"> Shipped </span>
                </div>
                <div class="step @if($order->status >= 4) active @endif">
                    <span class="icon"> <i class="fa fa-box"></i> </span>
                    <span class="text"> Delivered </span>
                </div>
            </div>
        @endif

        <!-- this row will not appear when printing -->
        <div class="row no-print">
            <div class="col-12">
                <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                {{--                <button type="button" class="btn btn-danger float-right" style="margin-right: 5px;">--}}
                {{--                    <i class="fas fa-times-circle"></i> Cancel--}}
                {{--                </button>--}}
                <form class="d-inline" action="{{ url("admin/order/detail", ["order"=>$order->id]) }}" method="post">
                    @method("PUT")
                    @csrf
                    <div class="float-right mr-2">
                        <div class="input-group mb-3">
                            <select class="form-control pr-5" name="status">
                                <option value="0">Order Placed</option>
                                <option value="1">Payment Received</option>
                                <option value="2">Order Processing</option>
                                <option value="3">Shipped</option>
                                <option value="4">Delivered</option>
                                <option value="5">Cancel</option>
                                <option value="6">On Hold</option>
                            </select>
                            <span class="input-group-append">
                                <button type="submit" class="btn btn-primary">Change status</button>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.invoice -->
@endsection

