@extends('layouts.frontend.site')
@section('title',$title)
@section('header')

@endsection
@section('footer')

@endsection
@section('content')
<section class="post_all body container">
    <div class="post_list">
        <div id="" class="h4 pb-2 mb-4  border-bottom border-danger fst-italic">
            <span class="title" >TIN TỨC ANIME</span>
        </div>
        <div class="row">
        @foreach($list_post as $post)
        <div class="col-md-3 col-12">
        <x-post-item :rowpost="$post"/>
        </div>
    @endforeach
</div>
    </div>
   

    <div class="text-center">  {!! $list_post->onEachSide(5)->links() !!}</div>

</section>


@endsection