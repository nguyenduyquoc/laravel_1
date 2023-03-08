@extends("guest.layout")
@section("title", "Order_detail")
@section("main-content")
    <section class="order_detail">
        <div class="container" style="margin-top: 45px; margin-bottom: 45px">
            <div class="row">
                <div class="col"></div>
                <div class="col-10" style="background-color: #ecd4d7; border-radius: 10px;">
                    <div class="thankyou text-center">
                        <h2 style="margin-top: 15px">Order Detail</h2>
                        <div class="shoping__cart__table">
                            <table>
                                <thead>
                                <tr>
                                    <th class="shoping__product">Products</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($cart as $item)
                                    <tr>
                                        <td class="shoping__cart__item">
                                            <h5>{{$item->name}}</h5>
                                        </td>
                                        <td class="shoping__cart__price">
                                            {{number_format($item->price)}}
                                        </td>
                                        <td class="shoping__cart__quantity">
                                            {{$item->buy_quantity}}
                                        </td>
                                        <td class="shoping__cart__total">
                                            ${{$item->price * $item->buy_quantity}}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row button" style="margin-top: 20px; margin-bottom: 10px">
                        <div class="col"></div>
                        <div class="col">
                            <p style="text-align: center"><a style="border-radius: 5px;background-color: #721c24; color: #fff;padding: 2px 7px" href="/guest">Back to buy</a></p>
                        </div>
                        <div class="col"></div>
                    </div>
                </div>
                <div class="col"></div>
            </div>
        </div>
    </section>
@endsection

