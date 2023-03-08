@extends("guest.layout")
@section("title", "Home")
@section("main-content")
    <section class="featured spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Featured Product</h2>
                    </div>
                    <div class="featured__controls">
                            <ul>
                                <li class="active" data-filter="*">All</li>
                                @foreach($top8_new_product as $item2)
                                <li data-filter=".{{ $item2->Category->name }}">{{ $item2->Category->name }}</li>
                                @endforeach
                            </ul>

                    </div>
                </div>
            </div>
                <div class="row featured__filter">
                    @foreach($top8_new_product as $item)
                    <div class="col-lg-3 col-md-4 col-sm-6 mix oranges {{$item2->Category->name}}">
                        <div class="featured__item">
                            <div class="featured__item__pic set-bg" data-setbg="{{ $item->thumbnail }}">
                                <ul class="featured__item__pic__hover">
                                    <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                    <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                    <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                </ul>
                            </div>
                            <div class="featured__item__text">
                                <h6><a href="{{route("product_detail", ["product"=>$item->id])}}">{{ $item->name }}</a></h6>
                                <h5>${{ number_format($item->price) }}</h5>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
        </div>
    </section>
@endsection
