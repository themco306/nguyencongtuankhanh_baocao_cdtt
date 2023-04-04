@extends('layouts.frontend.site')
@section('title',$title??'Trang chủ')
@section('content')
<div class="">
<x-slider-show/>
</div>
    <section class="body container mt-4">
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
