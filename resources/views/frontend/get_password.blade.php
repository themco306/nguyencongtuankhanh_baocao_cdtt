@extends('layouts.frontend.site')
@section('title',$title??'Trang chủ')
@section('content')
<div class="container modal-body">
    
    <div class="col-6 my-4 px-4">
        <form action="{{ route('site.postget_password',['id'=>$id]) }}" method="post">
            @csrf
            <h4>Đặt lại mật khẩu</h4>
            <label for="password">Mật khẩu</label>
            <input type="password" name="password" id="password" class="form-control" >
            @if ($errors->has('password'))
                <div style="  font-size: small;
            " class="text-danger">
                    {{ $errors->first('password') }}
                </div>
            @endif
            <label for="confirm_password">Nhập lại mật khẩu</label>
            <input type="password" name="confirm_password" id="confirm_password" class="form-control" >
            @if ($errors->has('confirm_password'))
                <div style="  font-size: small;
            " class="text-danger">
                    {{ $errors->first('confirm_password') }}
                </div>
            @endif

            <button class="mt-2" type="submit">Lưu Mật Khẩu</button>
        </form>
    </div>


@endsection