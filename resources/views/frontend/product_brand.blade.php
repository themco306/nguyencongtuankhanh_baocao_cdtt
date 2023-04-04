@extends('layouts.frontend.site')
@section('title','Trang chủ')
@section('header')
<link rel="stylesheet" href="{{ asset('css/form_filter.css') }}">
@endsection
@section('footer')
<script src="{{ asset('js/form_filter.js') }}"></script>
@endsection
@section('content')
    <section class="body container mt-4 ">
        <div class="row ">
        <div class="col-md-3 form_filter">
            <div class="filter-price">
                <p>Lọc Theo Giá</p>
                <input type="text" class="js-range-slider" name="my_range" value=""
                data-skin="round"
                data-type="double"
                data-min="0"
                data-max="1000"
                data-grid="false"
            />
        
        <input type="number" maxlength="4" value="0" class="from"/>
        <input type="number" maxlength="4" value="1000" class="to"/>
            </div>
            <div class="filter-category">
                <p>Danh Mục Sản Phẩm</p>
                <ul>
                    @foreach ($list_category as $item)
                    <li>
                        <a href="{{ route('slug.index',['slug'=>$item->slug]) }}">
                            <i class="fa-solid fa-folder p-1" >
                            </i>
                            {{ $item->name }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="filter-brand">
                <p>Thương Hiệu</p>
                <ul>
                    @foreach ($list_brand as $item)
                    <li>
                        <a href="{{ route('slug.index',['slug'=>$item->slug]) }}">
                            <i class="fa-solid fa-folder {{ ($item->id==$brand->id)?'fa-folder-open fa-beat-fade':'fa-folder' }} }} p-1" >
                            </i>
                            {{ $item->name }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="product_cate col-md-9 ">

            <div id="" class="h4 pb-2 mb-4  border-bottom border-danger fst-italic">
                <a class="title" href=""> {{ $brand->name }}</a>
            </div>
    
            <div class="product my-3">
                <div class="row">
                    @foreach($list_product as $product)
                    @php
                        (($product->sale==null)||($product->sale->price_sale==$product->price))?$index=0:$index=1;
                    @endphp
                    <div class="col-6 col-md-4">
    
                        <div class="m-1 border text-center position-relative">
                            @if($index==1)
                            <div class="product-sale ">
                                <div class="sale-off">-{{ (int)(((($product->price)-($product->sale->price_sale))/($product->price))*100) }}%</div>
                                
                            </div>
                            @endif
                            <div  class="box-hover">
                            <a id="wishlist_product-url{{ $product->id }}" href="{{ route('slug.index',['slug'=>$product->slug]) }}">
                                <img class="img-product img-fluid" src="{{ asset('images/product/'.$product->images[0]->image) }} " id="wishlist_product-image{{ $product->id }}"
                                    alt="{{  $product->images[0]->image}}" />
                                <img class="img-change img-product img-fluid" src="{{ asset('images/product/'.$product->images[1]->image) }}"
                                    alt="{{  $product->images[0]->image}}" />
                            </a>
                        </div>
                            <h6 class="text-truncate">
                                <a href="">{{ $product->name }}</a>
                            </h6>
                            <input type="hidden" id="wishlist_product-name{{ $product->id }}" value="{{ $product->name }}">
                        
                            <div class="d-flex   justify-content-around ">
                                <div class="icon heart btn_wishlist" id="{{ $product->id }}" onclick="add_wishlist(this.id)">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" id="heart-icon{{ $product->id }}" class="w-6 h-6 ">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                      </svg>
                                      
                                </div>
                                @if($index==0)
                                <div>
                                    <input type="hidden" id="wishlist_product-price{{ $product->id }}" value="{{ number_format($product->price) }}đ">
                                    <p class="product2__price">{{ number_format($product->price) }}đ</p>
                                    <p class="product2__oldprice "> </p>
                                </div>
                                @else
                                <div>
                                    <input type="hidden" id="wishlist_product-price{{ $product->id }}" value="{{ number_format($product->sale->price_sale) }}đ">
                                <p class="product2__price">{{ number_format($product->sale->price_sale) }}đ</p>
                                <p class="product2__oldprice text-decoration-line-through">
                                    {{ number_format($product->price) }}đ</p>
                                </div>
                                @endif
                                <div class="icon cart">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 fa-beat">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                      </svg>
                                      
                                </div>
                            </div>
                           
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
    </div>
</div>


    </section>


@endsection