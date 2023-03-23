<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('css/login_admin.css') }}" />

    <title>Login Page</title>

  </head>

  <body>

    <section >
      <div class="form-box">
        <div class="form-value">
          <form action="{{ route('admin.postlogin') }}"name="form1" method="post" enctype="multipart/form-data">
            
            @csrf
            <h2>ĐĂNG NHẬP HỆ THỐNG</h2>
            <div class="inputbox">
              <ion-icon name="mail-outline"></ion-icon>
              <input type="text" name="username" value="admin" required />
              <label for="">Tài Khoản</label>
              
            </div>
            <div class="inputbox">
              <ion-icon name="lock-closed-outline"></ion-icon>
              <input type="password" name="password" value="123456"   required />
              <label for="">Mật Khẩu</label>
              
            </div>
        
            <div class="forget">
              <label for=""
                ><input type="checkbox" name="remember"/>Ghi nhớ mật khẩu
                <a href="#">Quên mật khẩu</a></label
              >
            </div>
            <input class="dangnhap" type="submit" name="DANGNHAP" value="Đăng Nhập">
            <div class='error_login text-danger'>
              @if(isset($error_login))
              {{ $error_login }}
              @endif
          </div>
          </form>
        </div>
      </div>
    </section>
    <script
      type="module"
      src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"
    ></script>
    <script
      nomodule
      src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"
    ></script>
  </body>
</html>
