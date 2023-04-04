@extends('layouts.frontend.site')
@section('title','Trang chủ')
@section('header')
<link
rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css"
/>
<link rel="stylesheet" href="{{ asset('css/buy_amount.css') }}">

@endsection
@section('footer')



<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
<script src="{{ asset('js/slider_bar.js') }}"></script>
<script src="{{ asset('js/buy-amount.js') }}"></script>
@endsection
@section('content')
<div class=" layout-product container body">
<div class="row mb-3">
    <div class="col-12">
        Trang chu
    </div>
    <div class="col-md-5 my-2">
        <section
        id="main-carousel"
        class="splide"
        aria-label="The carousel with thumbnails. Selecting a thumbnail will change the Beautiful Gallery carousel."
        >
        <div  class="splide__track">
          <ul class="splide__list">
            @foreach ($product->images as $item)
            <li class="splide__slide">
                <img class="img-fluid" src="{{ asset('images/product/'.$item->image) }}" alt="" />
              </li>
            @endforeach
          </ul>
        </div>
        </section>
        
        <section
        id="thumbnail-carousel"
        class="splide"
        aria-label="The carousel with thumbnails. Selecting a thumbnail will change the Beautiful Gallery carousel."
        >
        <div style="" class="splide__track">
        <ul class="splide__list">
          @foreach ($product->images as $item)
          <li class="splide__slide">
              <img class="img-fluid" src="{{ asset('images/product/'.$item->image) }}" alt="" />
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
                    @if($product->qty >0)
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
        @if ($product->sale->price_sale!=null)
        <p class="product2__pricemain d-inline-block"> {{ number_format($product->sale->price_sale)}}</p>
        <span class="text-decoration-line-through" >{{ number_format($product->price)}}</span>
        @else
        <p class="product2__pricemain d-inline-block"> {{ number_format($product->price)}}</p>
        @endif
        
        <div class="text-info my-2">
        </div>
        <div class="ms-4" id="buy-amount">
            <input type="hidden" value="{{ $product->qty }} " id="qty">
            <button class="minus-btn" onclick="handleMinus()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15" />
              </svg>
              </button>
            <input type="text" name="amount" id="amount" value="1">
            <button class="plus-btn" onclick="handlePlus()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
              </svg>              
              </button>
        </div>
        <div class="call-buy color-white text-center rounded py-2">
           
                @if ($product->qty >0)
                <a class="btn btn-success" href="">
                <p class="my-auto fs-4">Thêm vào giỏ hàng</p>
                </a>
                @else
                <a class="btn btn-success" href="">
                    <p class="my-auto fs-4">Thêm vào giỏ hàng</p>
                    </a>
                @endif
                

            
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
<div>
    <div class="product_cate ">

        <div id="" class="h4 pb-2 mb-4  border-bottom border-danger fst-italic">
            <span class="title" href="">SẢN PHẨM TƯƠNG TỰ</span>
        </div>

        <div class="product my-3">
            <div class="row">
                @foreach($same_products as $product)
                @php
                    (($product->sale->price_sale==null)||($product->sale->price_sale==$product->price))?$index=0:$index=1;
                @endphp
                <div class="col-6 col-md-3">

                    <div class="m-1 border text-center position-relative">
                        @if($index==1)
                        <div class="product-sale ">
                            <div class="sale-off">-{{ (int)(((($product->price)-($product->sale->price_sale))/($product->price))*100) }}%</div>
                            
                        </div>
                        @endif
                        <div  class="box-hover">
                        <a href="{{ route('slug.index',['slug'=>$product->slug]) }}">
                            <img class="img-product img-fluid" src="{{ asset('images/product/'.$product->images[0]->image) }}"
                                alt="{{  $product->images[0]->image}}" />
                            <img class="img-change img-product img-fluid" src="{{ asset('images/product/'.$product->images[1]->image) }}"
                                alt="{{  $product->images[0]->image}}" />
                        </a>
                    </div>
                        <h6 class="text-truncate">
                            <a href="">{{ $product->name }}</a>
                        </h6>
                        
                        <div class="d-flex   justify-content-around ">
                            <div class="icon heart">
                                <i class="fa-solid fa-heart"></i>
                            </div>
                            @if($index==0)
                            <div>
                                <p class="product2__price">{{ number_format($product->price) }}đ</p>
                                <p class="product2__oldprice "> </p>
                            </div>
                            @else
                            <div>
                            <p class="product2__price">{{ number_format($product->sale->price_sale) }}đ</p>
                            <p class="product2__oldprice text-decoration-line-through">
                                {{ number_format($product->price) }}đ</p>
                            </div>
                            @endif
                            <div class="icon cart">
                                <i class="fa-solid fa-cart-shopping me-1"></i>
                            </div>
                        </div>
                       
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
</div>
@endsection