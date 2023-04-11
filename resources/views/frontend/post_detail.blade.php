@extends('layouts.frontend.site')
@section('title',$title??'Trang chủ')
@section('footer')

@endsection
@section('content')
<div class="container body">
    <div class="row">
        <div class="col-3">
            <h4 class="fs-6">Bài viết khác</h4>
            <div class="post_list">
                
                    @foreach($list_post as $post)
                    <div class="col-md-12 col-12">
                    <x-post-item :rowpost="$post"/>
                    </div>
                @endforeach
          
            </div>
        </div>
        <div class="col-9">
            <div class=" border-bottom fst-italic">
                <h4> {{ $post_single->title }} </h4>
            </div>
            <div class="mx-5">
                {!! $post_single->detail !!} 
            </div>
        </div>
    </div>

</div>
@endsection