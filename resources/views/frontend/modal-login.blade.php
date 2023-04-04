
<div class="row ">
    <div class="col-6 my-4 px-4 border-end">
        <form action="{{ route('site.postlogin') }}" method="post">
            @csrf
            <h4>Đăng nhập</h4>
            <label for="username">Tên tài khoản hoặc địa chỉ email</label>
            <input type="text" name="username" id="username" class="form-control" value="{{ old('username') }}">
            @if ($errors->has('username'))
                <div style="  font-size: small;
            " class="text-danger">
                    {{ $errors->first('username') }}
                </div>
            @endif
            <label for="password">Mật khẩu</label>
            <input type="password" name="password" id="password" class="form-control" >
            @if ($errors->has('password'))
                <div style="  font-size: small;
            " class="text-danger">
                    {{ $errors->first('password') }}
                </div>
            @endif
            <input type="checkbox" name="remember" id="remember">
            <label for="remember" class="pt-3 pb-2">Ghi nhớ tài khoản</label><br />
            <div style="  font-size: medium;
                " class="text-danger mb-2">
                @if(isset($error_login))
                {{ $error_login }}
                @endif
            </div>
            <button type="submit">Đăng nhập</button><br />
            <a href="">Quên mật khẩu?</a>
        </form>
    </div>
    <div class="col-6 my-4 px-4">
        <form action="{{ route('site.register') }}" method="get">
            @csrf
            <h4>đăng ký</h4>
            <label for="email">Địa chỉ email</label>
            <input type="text" name="email" id="email" class="form-control"
                placeholder="abc123@gmail.com" value="{{ old('email') }}">
            @if ($errors->has('email'))
                <div style="  font-size: small;
                " class="text-danger">
                    {{ $errors->first('email') }}
                </div>
            @endif
            <p>Mật khẩu sẽ được gửi đến email của bạn</p>
            <p class="content">Dữ liệu cá nhân của bạn sẽ được sử dụng để hỗ trợ trải nghiệm của bạn
                trên toàn bộ trang web này, để quản lý quyền truy cập vào tài khoản của bạn và cho các
                mục đích khác được mô tả trong <a href="">chính sách riêng tư</a>.</p>
            <button type="submit">Đăng ký</button>
        </form>
    </div>
</div>