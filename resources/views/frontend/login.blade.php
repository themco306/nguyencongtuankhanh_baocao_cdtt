@extends('layouts.frontend.site')
@section('title',$title??'Trang chủ')
@section('content')
<div class="container modal-body">
    
    <div class="text-center"><h4>TÀI KHOẢN CỦA TÔI</h4></div>
    @includeIf('frontend.modal-login')
</div>


@endsection