@php
    use App\Helpers\ProductHelper;

    $prices = ProductHelper::calculatePrice($product);
    $discountedPrice = number_format($prices->discountedPrice);
    $price = number_format($prices->price);
    $discount = $prices->discount;
    $inSale = $prices->inSale;
@endphp


{{-- <div class="m-1 border text-center position-relative">
    @if ($inSale == true)
    <div class="product-sale ">
        <div class="sale-off">-{{$discount }}%</div>
        
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
        @if ($inSale == false)
        <div>
            <input type="hidden" id="wishlist_product-price{{ $product->id }}" value="{{ $price }}đ">
            <p class="product2__price">{{$price}}đ</p>
            <p class="product2__oldprice "> </p>
        </div>
        @else
        <div>
            <input type="hidden" id="wishlist_product-price{{ $product->id }}" value="{{$discountedPrice}}đ">
        <p class="product2__price">{{ $discountedPrice }}đ</p>
        <p class="product2__oldprice text-decoration-line-through">
            {{ $price }}đ</p>
        </div>
        @endif
        @if ($product->qty > 0)
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
   
</div> --}}
<div class="card-product">
    <div class="card-top">
        @if ($inSale == true)
        <div class="product-sale ">
            <div class="sale-off">-{{$discount }}%</div>
            
        </div>
        @endif
        <div class="icon-fav " id="{{ $product->id }}" onclick="add_wishlist(this.id)">
            <input type="hidden" id="wishlist_product-name{{ $product->id }}" value="{{ $product->name }}">
           
                <input type="hidden" class="amount" id="amount" name="amount" value="1">
                <svg xmlns="http://www.w3.org/2000/svg" height="1.5em" viewBox="0 0 512 512"
                    class="heart-icon{{ $product->id }}"
                    fill="rgba(36, 23, 0, 0.747)"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                    <path
                        d="M47.6 300.4L228.3 469.1c7.5 7 17.4 10.9 27.7 10.9s20.2-3.9 27.7-10.9L464.4 300.4c30.4-28.3 47.6-68 47.6-109.5v-5.8c0-69.9-50.5-129.5-119.4-141C347 36.5 300.6 51.4 268 84L256 96 244 84c-32.6-32.6-79-47.5-124.6-39.9C50.5 55.6 0 115.2 0 185.1v5.8c0 41.5 17.2 81.2 47.6 109.5z" />
                </svg>
        </div>
        
            @if ($product->qty > 0)
            <div class="icon-cart" onclick="add2cart(this.id)" id="{{ $product->id }}">
                <input type="hidden" value="{{ route('site.addcart') }}" id='addcart_url'>
                <svg xmlns="http://www.w3.org/2000/svg" height="1.5em"  fill="rgba(36, 23, 0, 0.747)"
                viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                <path
                    d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96zM252 160c0 11 9 20 20 20h44v44c0 11 9 20 20 20s20-9 20-20V180h44c11 0 20-9 20-20s-9-20-20-20H356V96c0-11-9-20-20-20s-20 9-20 20v44H272c-11 0-20 9-20 20z" />
            </svg>
                </div>
            @else
            <div class="icon-cart ">
            <svg xmlns="http://www.w3.org/2000/svg" height="1.5em" style="fill: #cccc; "
            viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
            <path
                d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96zM252 160c0 11 9 20 20 20h44v44c0 11 9 20 20 20s20-9 20-20V180h44c11 0 20-9 20-20s-9-20-20-20H356V96c0-11-9-20-20-20s-20 9-20 20v44H272c-11 0-20 9-20 20z" />
        </svg>
            </div>
            @endif
           

        <a id="wishlist_product-url{{ $product->id }}" href="{{ route('slug.index',['slug'=>$product->slug]) }}"><img class="img-1" id="wishlist_product-image{{ $product->id }}"
            src="{{ asset('images/product/' . $product->images[0]->image) }}" alt="">
        <img src="{{ asset('images/product/' . $product->images[1]->image) }}" alt="">
        </a>
    </div>
    <div class="card-bottom ">
      
        <div class="card-name col-12 ">
            <a href="{{ route('slug.index',['slug'=>$product->slug]) }}">{{ $product->name }}</a>
        </div>
        <div class="card-price col-12">
            @if ($inSale == false)
                <input type="hidden" id="wishlist_product-price{{ $product->id }}" value="{{ $price }}đ">
                <span class="price">{{ $price }}đ</span>
                
            @else
                <input type="hidden" id="wishlist_product-price{{ $product->id }}" value="{{ $discountedPrice }}đ">
                <span class="price">{{ $discountedPrice }}đ</span>
                <span class="price_sale text-decoration-line-through">
                    {{ $price }}đ</span>
            @endif
        </div>
    </div>
</div>
