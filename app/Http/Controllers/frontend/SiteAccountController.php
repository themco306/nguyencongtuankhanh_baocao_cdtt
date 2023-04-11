<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SiteAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function myaccount()
    {
        $user = Auth::guard('users')->user();
        return view('frontend.customer.myaccount', compact('user'));
    }
    public function edit()
    {
        $user = Auth::guard('users')->user();
        return view('frontend.customer.myaccount-edit', compact('user'));
    }
    public function postedit(Request $request)
    {
        $id = Auth::guard('users')->user()->id;
        Validator::extend('gmail', function ($attribute, $value, $parameters, $validator) {
            return Str::endsWith($value, '@gmail.com');
        });
        $request->validate([
            'name' => 'unique:user,name,' . $id . ',id',
            'email' => 'required|unique:user,email,' . $id . ',id|email|gmail|max:30',
            'password' => 'required_with:new_password,confirm_password|max:40',
            'new_password' => 'required_with:password,confirm_password|max:40',
            'confirm_password' => 'required_with:new_password,password|same:new_password|max:40'
        ], [
            'name.unique' => 'Tên đã được sử dụng. Vui lòng chọn tên khác.',
            'email.unique' => 'Tên đã được sử dụng. Vui lòng chọn tên khác.',
            'email.required' => 'Bạn chưa điền email',
            'email.email' => 'Email không hợp lệ',
            'email.gmail' => 'Gmail không hợp lệ "@gmail.com"',
            'email.max' => 'Email không được dài quá 30 ký tự',
            'password.required_with' => 'Bạn phải nhập mật khẩu cũ khi thay đổi mật khẩu mới.',
            'password.max' => 'Mật khẩu cũ không được vượt quá :max ký tự.',
            'new_password.required_with' => 'Bạn phải nhập mật khẩu mới khi thay đổi mật khẩu.',
            'new_password.max' => 'Mật khẩu mới không được vượt quá :max ký tự.',
            'confirm_password.required_with' => 'Bạn phải xác nhận mật khẩu mới khi thay đổi mật khẩu mới.',
            'confirm_password.same' => 'Mật khẩu xác nhận phải giống với mật khẩu mới.',
            'confirm_password.max' => 'Mật khẩu xác nhận không được vượt quá :max ký tự.'
        ]);
        $user = User::find($id);
        $user->name = $request->name;
        if ($request->password != null) {
            if (!password_verify($request->password, $user->password)) {
                return redirect()->back()->with('message', ['type' => 'danger', 'msg' => 'Mật khẩu hiện tại không khớp với mật khẩu của bạn trong hệ thống']);
            }
            $user->password = bcrypt($request->new_password);
        }
        $user->email = $request->email;
        $parts = explode('@', $request->email);
        $user->username = $parts[0];
        $user->gender = $request->gender;
        $user->phone = $request->phone;
        $user->updated_at = date('Y-m-d H:i:s');
        $user->updated_by = Auth::guard('users')->user()->id;
        //upload file

        if ($request->def_image == 1) {
            if ($user->gender) {
                $user->image = 'user_women.jpg';
            } else {
                $user->image = 'user_men.jpg';
            }
        }
        if ($request->hasFile('image')) {
            $path = 'images/user/';
            if (File::exists(public_path($path . $user->image)) && ($user->image != 'user_women.jpg') && ($user->image != 'user_men.jpg')) {
                File::delete(public_path($path . $user->image));
            }
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = $user->username . '.' . $extension;
            $file->move($path, $filename);
            $user->image = $filename;
        } else {
            if ($user->gender == 1 && (($user->image == 'user_women.jpg') || ($user->image == 'user_men.jpg'))) {
                $user->image = 'user_women.jpg';
            }
            if ($user->gender == 0 && (($user->image == 'user_women.jpg') || ($user->image == 'user_men.jpg'))) {
                $user->image = 'user_men.jpg';
            }
        }
        if ($user->save()) {
            return redirect()->route('account.edit')->with('message', ['type' => 'success', 'msg' => 'Cập nhật thành công!']);
        }
        return redirect()->route('account.edit')->with('message', ['type' => 'danger', 'msg' => 'Cập nhật thất bại!!']);
    }
    public function order()
    {
        $user = Auth::guard('users')->user();
        $order = $user->order;

        $orderdetail = array();
        foreach ($order as $item) {
            $orderdetail[] = $item->orderdetail;
        }

        $a_total_price = array();
        $a_total_qty = array();
        foreach ($orderdetail as $items) {
            $total_price = 0;
            $total_qty = 0;
            foreach ($items as $item) {
                $total_price += $item->amount;
                $total_qty += $item->qty;
            }
            $a_total_price[] = $total_price;
            $a_total_qty[] = $total_qty;
        }
        $i = 0;
        foreach ($order as $item) {
            $item['a_total_price'] = $a_total_price[$i];
            $item['a_total_qty'] = $a_total_qty[$i++];
        }
        $list_status = [
            ['type' => 'secondary', 'text' => 'Chưa xác nhận'],
            ['type' => 'primary', 'text' => 'Đã xác nhận, chưa thanh toán'],
            ['type' => 'success', 'text' => 'Đã thanh toán'],
            ['type' => 'info', 'text' => 'Đóng gói'],
            ['type' => 'warning', 'text' => 'Vận chuyển'],
            ['type' => 'success', 'text' => 'Đã giao'],
            ['type' => 'danger', 'text' => 'Đã hủy'],
        ];
        return view('frontend.customer.myaccount-order', compact('user', 'order', 'list_status'));
    }
    public function address()
    {
        $user = Auth::guard('users')->user();
        return view('frontend.customer.myaccount-address', compact('user'));
    }
    public function postaddress(Request $request)
    {
        $request->validate([
            'province' => 'required',
            'district' => 'required',
            'ward' => 'required',
            'address' => 'required',

        ], [
            'province.required' => 'Bạn chưa chọn Tỉnh/Thành phố',
            'district.required' => 'Bạn chưa chọn Quận/Huyện',
            'ward.required' => 'Bạn chưa chọn Phường/Xã',
            'address.required' => 'Bạn chưa điền địa chỉ cụ thể',

        ]);
        $user = User::find(Auth::guard('users')->user()->id);
        $user->province = $request->province;
        $user->district = $request->district;
        $user->ward = $request->ward;
        $user->address = $request->address;
        $user->updated_at = date('Y-m-d H:i:s');
        $user->updated_by = Auth::guard('users')->user()->id;
        $user->save();
        return redirect()->route('account.address')->with('message', ['type' => 'success', 'msg' => 'Thay đổi địa chỉ thành công']);
    }
    public function wishlist()
    {
        $user = Auth::guard('users')->user();
        return view('frontend.customer.myaccount-wishlist', compact('user'));
    }
    public function temp_wishlist()
    {
        return view('frontend.temp_wishlist');
    }
}
