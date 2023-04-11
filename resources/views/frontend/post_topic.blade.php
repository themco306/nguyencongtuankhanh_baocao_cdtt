@extends('layouts.frontend.site')
@section('title','Trang chủ')
@section('header')

@endsection
@section('footer')

@endsection
@section('content')
<section class="post_all body container">
    <div class="post_list">
        <div id="" class="h4 pb-2 mb-4  border-bottom border-danger fst-italic">
            <span class="title" >{{ $topic->name }}</span>
        </div>
        @foreach($list_post as $post)
        <div class="col-md-3 col-12">
        <x-post-item :rowpost="$post"/>
        </div>
    @endforeach
    </div>
   

    <div class="text-center">  {!! $list_post->onEachSide(5)->links() !!}</div>

</section>


@endsection