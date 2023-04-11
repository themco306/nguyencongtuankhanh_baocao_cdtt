@extends('layouts.frontend.site')
@section('title',$title??'Trang chủ')
@section('footer')

@endsection
@section('content')
<div class="container">
<div class=" border-bottom fst-italic">
    <h4> {{ $page->title }} </h4>
</div>
<div class="mx-5">
    {!! $page->detail !!} 
</div>
</div>
@endsection
