@extends('layouts.frontend.site')
@section('title', 'Trang chủ')
@section('header')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" />
    <link rel="stylesheet" href="{{ asset('css/buy_amount.css') }}">

@endsection
@section('footer')



    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    <script src="{{ asset('js/slider_bar.js') }}"></script>
    <script src="{{ asset('js/amountcart.js') }}"></script>
    <script src="{{ asset('js/add2cart.js') }}"></script>
@endsection
@section('content')
    <div class=" layout-product container body">
        <div class="row mb-3">
            <div class="col-12">
                <h4>{{ $product->name }}</h4>
            </div>
            <div class="col-md-5 my-2">
                <section id="main-carousel" class="splide"
                    aria-label="The carousel with thumbnails. Selecting a thumbnail will change the Beautiful Gallery carousel.">
                    <div class="splide__track">
                        <ul class="splide__list">
                            @foreach ($product->images as $item)
                                <li class="splide__slide">
                                    <img class="img-fluid" src="{{ asset('images/product/' . $item->image) }}"
                                        alt="" />
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </section>

                <section id="thumbnail-carousel" class="splide"
                    aria-label="The carousel with thumbnails. Selecting a thumbnail will change the Beautiful Gallery carousel.">
                    <div style="" class="splide__track">
                        <ul class="splide__list">
                            @foreach ($product->images as $item)
                                <li class="splide__slide">
                                    <img class="img-fluid" src="{{ asset('images/product/' . $item->image) }}"
                                        alt="" />
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </section>

            </div>
            <div class="col-md-3 my-2">
                <h4 class="border-bottom py-1 text-uppercase fw-bold">Thông tin sản phẩm</h4>
                <div class="col-md-12 ">
                    <div class="row">
                        <div class="col-6">
                            <p>> Xuất sứ </p>
                        </div>
                        <div class="col-6">
                            <p class="fw-bold"></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 ">
                    <div class="row">
                        <div class="col-6">
                            <p>> Tình trạng </p>
                        </div>
                        <div class="col-6">
                            @if ($product->qty > 0)
                                <p class="fw-bold text-success">Còn hàng</p>
                            @else
                                <p class="fw-bold text-danger">Hết hàng</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-12 ">
                    <div class="row">
                        <div class="col-6">
                            <p>> Đơn vị tiền </p>
                        </div>
                        <div class="col-6">
                            <p class="fw-bold">VNĐ</p>
                        </div>
                    </div>
                </div>
                <span>Giá bán:</span>
                @if ($product->sale->price_sale != null)
                    <p class="product2__pricemain d-inline-block"> {{ number_format($product->sale->price_sale) }}</p>
                    <span class="text-decoration-line-through">{{ number_format($product->price) }}</span>
                @else
                    <p class="product2__pricemain d-inline-block"> {{ number_format($product->price) }}</p>
                @endif

                <div class="text-info my-2">
                </div>
                <div class="ms-4 buy-amount form-qty" >
                    <input type="hidden" value="{{ $product->qty }} " class="qty_max">
                    <button class="minus-btn" >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15" />
                        </svg>
                    </button>
                    <input type="text" class="amount" id="amount" name="amount" value="1">
                    <button class="plus-btn" >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </button>
                </div>
                <div class="row call-buy color-white text-center rounded py-2">
                    <div class="col-12">
                    <input type="hidden" value="{{ route('site.addcart') }}" id='addcart_url'>
                    @if ($product->qty > 0)
                        <button class="btn btn-success" onclick="add2cart(this.value)" value="{{ $product->id }}">
                           Thêm vào giỏ hàng
                        </button>
                    @else
                    <button class="btn btn-success" @disabled(true)>
                        <p class="my-auto ">Thêm vào giỏ hàng</p>
                    </button>
                    @endif
                </div>
                <div class="col-12 mt-3">
                    <a class="d-none" id="wishlist_product-url{{ $product->id }}" href="{{ route('slug.index',['slug'=>$product->slug]) }}">
                    </a>
                        <input type="hidden" id="wishlist_product-name{{ $product->id }}" value="{{ $product->name }}">
                       <input type="hidden" id="wishlist_product-price{{ $product->id }}" value="{{ number_format($product->price) }}đ">
                       <img class="img-change d-none img-product img-fluid" src="{{ asset('images/product/'.$product->images[0]->image) }} " id="wishlist_product-image{{ $product->id }}"/>

                    <div class="icon heart btn_wishlist" >
                        <button class="btn btn-danger " onclick="add_wishlist(this.value)" value="{{ $product->id }}">
                            Thêm vào yêu thích
                         </button>
                          
                    </div>
                </div>


                </div>
            </div>
            <div class="col-md-4 my-2">

                <div class="row ">


                </div>
                <div class="description border rounded-top">
                    <p class="bg-blue text-center rounded-top fs-5 text-white py-1 mb-1">Mô tả chi tiết</p>
                    <div class="ms-2">{!! $product->detail !!}</div>
                </div>
            </div>
        </div>
        
      
        

        
        <div class="product_cate ">

            <div id="" class="h4 pb-2 mb-4  border-bottom border-danger fst-italic">
                <span class="title" href="">SẢN PHẨM TƯƠNG TỰ</span>
            </div>

            <div class="product my-3">
                <div class="row">
                    @foreach ($same_products as $product)
                    <div class="col-6 col-md-3">
                        <x-product-item :productitem="$product" />
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
  
@endsection
