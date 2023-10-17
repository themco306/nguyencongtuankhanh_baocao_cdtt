@extends('layouts.frontend.site')
@section('title',$title??'Trang chủ')
@section('content')
<div class="container modal-body">
    
    <div class="col-6 my-4 px-4">
        <form action="{{ route('site.postforget_password') }}" method="post">
            @csrf
            <h4>Lấy lại mật khẩu</h4>
            <label for="email">Địa chỉ email đã đăng ký</label>
            <input type="text" name="email" id="email" class="form-control"
                placeholder="abc123@gmail.com" value="{{ old('email') }}">
            @if ($errors->has('email'))
                <div style="  font-size: small;
                " class="text-danger">
                    {{ $errors->first('email') }}
                </div>
            @endif
            <p>Một liên kết sẽ được gửi vào Email của bạn</p>
            <p class="content">Dữ liệu cá nhân của bạn sẽ được sử dụng để hỗ trợ trải nghiệm của bạn
                trên toàn bộ trang web này, để quản lý quyền truy cập vào tài khoản của bạn và cho các
                mục đích khác được mô tả trong <a href="">chính sách riêng tư</a>.</p>
            <button type="submit">Gửi</button>
        </form>
    </div>
</div>


@endsection