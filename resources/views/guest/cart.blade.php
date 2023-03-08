@extends("guest.layout")
@section("title", "Cart")
@section("main-content")
<section class="breadcrumb-section set-bg" data-setbg="/assets/img/breadcrumb.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Shopping Cart</h2>
                    <div class="breadcrumb__option">
                        <a href="/guest">Home</a>
                        <span>Shopping Cart</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Shoping Cart Section Begin -->
<section class="shoping-cart spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
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

                        @forelse($cart as $item)
                        <tr>
                            <td class="shoping__cart__item">
                                <img width="80" src="{{$item->thumbnail}}" alt="">
                                <h5>{{$item->name}}</h5>
                            </td>
                            <td class="shoping__cart__price">
                                {{number_format($item->price)}}
                            </td>
                            <td class="shoping__cart__quantity">
                                <div class="quantity">
                                    <div class="pro-qty">
                                        <input name="buy_quantity[{{$item->id}}]" type="text" value="{{$item->buy_quantity}}">
                                    </div>
                                    @if($item->buy_quantity > $item->quantity)
                                        <p class="text-danger">Số lượng mua vượt quá {{$item->quantity}}</p>
                                    @endif

                                </div>
                            </td>
                            <td class="shoping__cart__total">
                                ${{$item->price * $item->buy_quantity}}
                            </td>
                            <td class="shoping__cart__item__close">
                                <a href="{{url("remove_item", ["product"=>$item->id])}}"><span class="icon_close"></span></a>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="6">Không có sản phẩm nào trong giỏ hàng</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="shoping__cart__btns">
                    <a href="/guest" class="primary-btn cart-btn">CONTINUE SHOPPING</a>
                    <a href="#" class="primary-btn cart-btn cart-btn-right"><span class="icon_loading"></span>
                        Upadate Cart</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="shoping__continue">
                    <div class="shoping__discount">
                        <h5>Discount Codes</h5>
{{--                        <form action="#">--}}
{{--                            <input type="text" placeholder="Enter your coupon code">--}}
{{--                            <button type="submit" class="site-btn">APPLY COUPON</button>--}}
{{--                        </form>--}}
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="shoping__checkout">
                    <h5>Cart Total</h5>
                    <ul>
                        <li>Subtotal <span>${{number_format($grand_total)}}</span></li>
                        <li>Total <span>${{number_format($grand_total)}}</span></li>
                    </ul>
                    @if($can_checkout)
                    <a href="/checkout" class="primary-btn">PROCEED TO CHECKOUT</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
