<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Validator;

class SiteLoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getlogin()
    {
        return view('frontend.login');
    }
    public function register(Request $request)
    {

        Validator::extend('gmail', function ($attribute, $value, $parameters, $validator) {
            return Str::endsWith($value, '@gmail.com');
        });
        $request->validate([
            'email' => 'required|email|gmail|max:30'
        ], [
            'email.required' => 'Bạn chưa điền email',
            'email.email' => 'Email không hợp lệ',
            'email.gmail' => 'Gmail không hợp lệ "@gmail.com"',
            'email.max' => 'Email không được dài quá 30 ký tự'

        ]);
        $actived_token = strtoupper(Str::random(6));
        $user = new User();
        $user->email = $request->email;
        $user->actived_token = $actived_token;
        $parts = explode('@', $request->email);
        $user->username = $parts[0];
        $user->name = $parts[0];
        $password_send = Str::random(8);
        $user->password = bcrypt($password_send);

        if ($user->save()) {
            return $this->send_mail($user, $password_send);
        }
    }
    public function actived_again($user)
    {
        $user = User::find($user);
        $user->actived_token = strtoupper(Str::random(6));
        if ($user->save()) {
            return $this->send_mail($user);
        }
    }
    public function send_mail($user, $password_send = null)
    {
        $sent = Mail::send(
            'emails.actived_send',
            compact('user', 'password_send'),
            function ($send_email) use ($user) {
                $send_email->subject('ShopTK - Xác nhận tài khoản');
                $send_email->to($user->email, $user->name);
            }
        );
        if (!$sent) {
            $user->delete();
            return redirect()->route('site.getlogin')->with('message', ['type' => 'danger', 'msg' => 'Email của bạn không tồn tại!! Vui lòng nhập lại!!']);
        } else {
            return redirect()->route('site.getlogin')->with('message', ['type' => 'success', 'msg' => 'Đăng ký thành công vui lòng vào Email để xác nhận!!']);
        }
    }
    public function actived($user, $actived_token)
    {
        $user = User::find($user);

        if ($user->actived_token === $actived_token) {
            $user->status = 1;
            $user->actived_token = null;
            $user->save();
            return redirect()->route('site.getlogin')->with('message', ['type' => 'success', 'msg' => 'Xác nhận thành công !! Vui lòng đăng nhập!!']);
        } else {
            return redirect()->route('site.getlogin')->with('message', ['type' => 'danger', 'msg' => 'Mã xác nhận đã bị chỉnh sửa!!']);
        }
    }
    public function postlogin(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50',
            'password' => 'required'
        ], [
            'username.required' => 'Bạn chưa điền tên tài khoản hoặc email',
            'username.max' => 'Không được dài quá 50 ký tự',
            'password.required' => 'Bạn chưa điền mật khẩu'

        ]);
        $username = $request->username;
        $password = $request->password;
        $data = array('password' => $password);
        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $data['email'] = $username;
        } else {
            $data['username'] = $username;
        }
        $remember = $request->has('remember');
        if (Auth::guard('users')->attempt($data, $remember)) {
            $request->session()->regenerate();
            /*====================================*/
            if (Auth::guard('users')->user()->status == 2) {
                $url = route('site.actived_again', ['id' => Auth::guard('users')->user()->id]);
                $html = 'Bạn chưa xác minh tài khoản && <a style="font-size: medium; color:white;" href="' . $url . '">click vào đây để xác minh</a>';
                Auth::guard('users')->logout();
                return redirect()->route('site.getlogin')->with('message', ['type' => 'danger', 'msg' => $html]);
            }
            if (Auth::guard('users')->user()->status == 0) {
                Auth::guard('users')->logout();
                return redirect()->route('site.getlogin')->with('message', ['type' => 'danger', 'msg' => 'Tài khoản của bạn đã bị xóa']);
            }
            return redirect()->route('site.index');
        }
        $error_login = "Thông tin đăng nhập không chính xác";
        return view('frontend.login', compact('error_login'));
    }
    public function logout(Request $request)
    {
        Auth::guard('users')->logout();
        return redirect()->route('site.index');
    }
}
