@extends('layouts.frontend.site')
@section('title','Trang chủ')
@section('header')
<link rel="stylesheet" href="{{ asset('css/form_filter.css') }}">
@endsection
@section('footer')
<script src="{{ asset('js/add2cart.js') }}"></script>
<script src="{{ asset('js/form_filter.js') }}"></script>
@endsection
@section('content')
    <section class="body container mt-4 ">
        <div class="row ">
        <div class="col-md-3 form_filter">
            <x-site-filter :slugselect="$cat->slug"/>
        </div>
        <div class="product_cate col-md-9 ">

            <div id="" class="h4 row pb-2 mb-4  border-bottom border-danger fst-italic">
                <div class="col-9">
                <a class="title" href=""> {{ $cat->name }}</a>
            </div>
                <div class="col-3 text-end">
                    @includeIf('frontend.select-sort')
                </div>
            </div>
    
            <div class="product my-3">
                <div class="row">
                    @foreach($list_product as $product)
                    <div class="col-6 col-md-4">
                        <x-product-item :productitem="$product"/>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="text-center">  {!! $list_product->appends(['gia' => request('gia'), 'ten' => request('ten')])->onEachSide(5)->links() !!}</div>
    </div>
</div>


    </section>


@endsection