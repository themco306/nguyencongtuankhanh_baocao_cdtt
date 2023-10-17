@php
(($product->sale==null)||($product->sale->price_sale==$product->price))?$index=0:$index=1;
@endphp


<div class="m-1 border text-center position-relative">
    @if($index==1)
    <div class="product-sale ">
        <div class="sale-off">-{{ (int)(((($product->price)-($product->sale->price_sale))/($product->price))*100) }}%</div>
        
    </div>
    @endif
    <div  class="box-hover">
    <a id="wishlist_product-url{{ $product->id }}" href="{{ route('slug.index',['slug'=>$product->slug]) }}">
        <img class="img-change  img-product img-fluid" src="{{ asset('images/product/'.$product->images[0]->image) }} " id="wishlist_product-image{{ $product->id }}"
            alt="{{  $product->images[0]->image}}" />
        <img class="img-product img-fluid" src="{{ asset('images/product/'.$product->images[1]->image) }}"
            alt="{{  $product->images[0]->image}}" />
    </a>
</div>
    <h6 class="text-truncate">
        <a href="">{{ $product->name }}</a>
    </h6>
    <input type="hidden" id="wishlist_product-name{{ $product->id }}" value="{{ $product->name }}">
    <input type="hidden" class="amount" id="amount" name="amount" value="1">
    <div class="d-flex   justify-content-around ">
        <div class="icon heart btn_wishlist" id="{{ $product->id }}" onclick="add_wishlist(this.id)">
            <svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"  class="w-6 h-6 heart-icon{{ $product->id }}">
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
        @if ($product->qty>0)
        <div class="icon cart"  onclick="add2cart(this.id)" id="{{ $product->id }}">
            <input type="hidden" value="{{ route('site.addcart') }}" id='addcart_url'>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 fa-beat">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
              </svg>
            </a>
        </div>
        @else
        <div class="icon cart"  >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 " style="color: #cccc; ">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
              </svg>
           
        </div>
        @endif
       
    </div>
   
</div>
