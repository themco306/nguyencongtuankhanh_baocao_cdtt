@extends('layouts.frontend.site')
@section('title',$title??'Trang chủ')
@section('footer')
<script src="{{ asset('js/add2cart.js') }}"></script>
@endsection
@section('content')
<div class="">
<x-slider-show/>
</div>
    <section class="body container mt-4">
        <div class="product_cate ">

            <div id="" class="h4 pb-2 mb-4  border-bottom border-danger fst-italic">
                <a class="title" > Sản Phẩm Mới</a>
            </div>
    
            <div class="product my-3">
                <div class="row">
                    @foreach($new_product as $product)
                    <div class="col-6 col-md-3">
                            <x-product-item :productitem="$product"/>
                    </div>
                    @endforeach
                </div>
            </div>
    </div>
        @foreach ($list_category as $category)
            <x-product-home :rowcate="$category"/>
        @endforeach
        <div class="post_list">
            <div id="" class="h4 pb-2 mb-4  border-bottom border-danger fst-italic">
                <span class="title" >TIN TỨC ANIME</span>
            </div>
            <x-post-home />
        </div>



    </section>


@endsection
