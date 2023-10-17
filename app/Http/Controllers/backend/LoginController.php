<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getlogin()
    {
        return view('backend.login');
    }
    public function postlogin(Request $request)
    {

        $username = $request->username;
        $password = $request->password;
        $data = array('password' => $password);
        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $data['email'] = $username;
        } else {
            $data['username'] = $username;
        }
        $remember = $request->has('remember');
        if (Auth::guard('admin')->attempt($data, $remember)) {
            $request->session()->regenerate();

            return redirect()->route('dashboard.index');
        }
        $error_login = "Thông tin đăng nhập không chính xác";
        return view('backend.login', compact('error_login'));
    }
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.getlogin');
    }
}
