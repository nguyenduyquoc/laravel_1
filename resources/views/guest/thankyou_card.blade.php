@extends("guest.layout")
@section("title", "Thanksyou")
@section("main-content")
    <section class="thankyou_card">
        <div class="container" style="margin-top: 45px; margin-bottom: 45px">
            <div class="row">
                <div class="col"></div>
                <div class="col-10" style="background-color: #ecd4d7; border-radius: 10px;">
                    <div class="thankyou text-center">
                        <h3 style="margin-top: 15px">You have successfully placed your order</h3>
                        <h4 style="margin-top: 15px">We have received your order. Your order will be prepared and delivered to you as soon as possible</h4>
                        <h2 style="margin-top: 15px">Thanks you very much!!!</h2>
                    </div>
                    <div class="row button" style="margin-top: 20px; margin-bottom: 10px">
                        <div class="col">
                            <p style="text-align: right"><a style="border-radius: 5px;background-color: #721c24; color: #fff;padding: 2px 7px" href="/guest">Back to buy</a></p>
                        </div>
                        <div class="col">
                            <p class="left"><a style="border-radius: 5px;background-color: #721c24; color: #fff; padding: 2px 7px" href="/order_detail">Order details</a></p>
                        </div>
                    </div>
                </div>
                <div class="col"></div>
            </div>
        </div>
    </section>
@endsection
