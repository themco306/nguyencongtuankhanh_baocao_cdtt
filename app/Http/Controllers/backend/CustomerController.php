<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerStoreRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customer = User::where([['status', '!=', '0'], ['roles', '=', '0']])
            ->orderBy('created_at', 'desc')
            ->get();
        $title = 'Tất Cả Khách Hàng';
        return view("backend.customer.index", compact('customer', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Thêm Khách Hàng';
        return view("backend.customer.create", compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerStoreRequest $request)
    {
        $customer = new User();
        $customer->name = $request->name;
        $customer->username = $request->username;
        $customer->password = sha1($request->password);
        $customer->email = $request->email;
        $customer->gender = $request->gender;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->roles = 0;
        // $customer->level = 1;
        $customer->status = $request->status;
        $customer->created_at = date('Y-m-d H:i:s');
        $customer->created_by = Auth::guard('admin')->user()->id;
        //upload file

        if ($request->hasFile('image')) {
            $path = 'images/user/';
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = $customer->username . '.' . $extension;
            $file->move($path, $filename);
            $customer->image = $filename;
        } else {
            if ($customer->gender) {
                $customer->image = 'user_women.jpg';
            } else {
                $customer->image = 'user_men.jpg';
            }
        }
        if ($customer->save()) {
            return redirect()->route('customer.index')->with('message', ['type' => 'success', 'msg' => 'Thêm thành công!']);
        }
        return redirect()->route('customer.create')->with('message', ['type' => 'danger', 'msg' => 'Thêm thất bại!!']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $customer = User::find($id);
        if ($customer == null) {
            return redirect()->route('customer.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại']);
        }
        $title = 'Chi Tiết Khách hàng';
        return view("backend.customer.show", compact('title', 'customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $customer = User::where([['status', '!=', '0'], ['id', '=', $id], ['roles', '=', '0']])->first();
        if ($customer == null) {
            return redirect()->route('customer.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại']);
        }
        $title = 'Sửa Khách Hàng';
        return view('backend.customer.edit', compact('title', 'customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerUpdateRequest $request, $id)
    {
        $request->validate([
            'name' => 'unique:user,name,' . $id . ',id',
            'username' => 'unique:user,username,' . $id . ',id',
        ], [
            'name.unique' => 'Tên đã được sử dụng. Vui lòng chọn tên khác.',
            'username.unique' => 'Tên đã được sử dụng. Vui lòng chọn tên khác.'
        ]);
        $customer = User::find($id);
        $customer->name = $request->name;
        $customer->username = $request->username;
        if ($request->password != null) {
            $customer->password = sha1($request->password);
        }
        $customer->email = $request->email;
        $customer->gender = $request->gender;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->roles = 0;
        // $customer->level = 1;
        $customer->status = $request->status;
        $customer->created_at = date('Y-m-d H:i:s');
        $customer->created_by = Auth::guard('admin')->user()->id;
        //upload file

        if ($request->def_image == 1) {
            if ($customer->gender) {
                $customer->image = 'user_women.jpg';
            } else {
                $customer->image = 'user_men.jpg';
            }
        }
        if ($request->hasFile('image')) {
            $path = 'images/user/';
            if (File::exists(public_path($path . $customer->image)) && ($customer->image != 'user_women.jpg') && ($customer->image != 'user_men.jpg')) {
                File::delete(public_path($path . $customer->image));
            }
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = $customer->username . '.' . $extension;
            $file->move($path, $filename);
            $customer->image = $filename;
        } else {
            if ($customer->gender == 1 && (($customer->image == 'user_women.jpg') || ($customer->image == 'user_men.jpg'))) {
                $customer->image = 'user_women.jpg';
            }
            if ($customer->gender == 0 && (($customer->image == 'user_women.jpg') || ($customer->image == 'user_men.jpg'))) {
                $customer->image = 'user_men.jpg';
            }
        }
        if ($customer->save()) {
            return redirect()->route('customer.index')->with('message', ['type' => 'success', 'msg' => 'Cập nhật thành công!']);
        }
        return redirect()->route('customer.edit')->with('message', ['type' => 'danger', 'msg' => 'Cập nhật thất bại!!']);
    }
    public function trash()
    {
        $customer = User::where([['status', '=', '0'], ['roles', '=', '0']])
            ->orderBy('updated_at', 'asc')
            ->get();
        $title = 'Thùng rác khách hàng';
        return view("backend.customer.trash", compact('customer', 'title'));
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $customer = User::find($id);
        if ($customer == null) {
            return redirect()->route('customer.trash')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }
        if ($customer->delete()) {
            $path = 'images/user/';
            if (File::exists(public_path($path . $customer->image)) && ($customer->image != 'user_women.jpg') && ($customer->image != 'user_men.jpg')) {
                File::delete(public_path($path . $customer->image));
            }
            return redirect()->route('customer.trash')->with('message', ['type' => 'success', 'msg' => 'Xóa vĩnh viễn thành công!']);
        }
        return redirect()->route('customer.trash')->with('message', ['type' => 'danger', 'msg' => 'Xóa thất bại!']);
    }

    public function delete($id)
    {
        $customer = User::find($id);
        if ($customer == null) {
            return redirect()->route('customer.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }
        $customer->status = 0;
        $customer->updated_at = date('Y-m-d H:i:s');
        $customer->updated_by = Auth::guard('admin')->user()->id;
        $customer->save();
        return redirect()->route('customer.index')->with('message', ['type' => 'success', 'msg' => 'Xóa thành công!&& vào thùng rác để xem!!!']);
    }

    public function delete_multi(Request $request)
    {
        if (isset($request->checkId)) {
            $list_id = $request->input('checkId');
            $count_max = sizeof($list_id);
            $count = 0;
            foreach ($list_id as $id) {
                $customer = User::find($id);
                if ($customer == null) {
                    return redirect()->route('customer.index')->with('message', ['type' => 'danger', 'msg' => "Có mẫu tin không tồn tại!Đã xóa $count/$count_max ! "]);
                }
                $customer->status = 0;
                $customer->updated_at = date('Y-m-d H:i:s');
                $customer->updated_by = Auth::guard('admin')->user()->id;
                $customer->save();
                $count++;
            }
            return redirect()->route('customer.index')->with('message', ['type' => 'success', 'msg' => "Xóa thành công $count/$count_max !&& Vào thùng rác để xem!!!"]);
        } else {
            return redirect()->route('customer.index')->with('message', ['type' => 'danger', 'msg' => 'Chưa chọn mẫu tin!']);
        }
    }

    public function status($id)
    {

        $customer = User::find($id);
        if ($customer == null) {
            return redirect()->route('customer.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }

        $customer->status = ($customer->status == 1) ? 2 : 1;
        $customer->updated_at = date('Y-m-d H:i:s');
        $customer->updated_by = Auth::guard('admin')->user()->id;
        $customer->save();
        return redirect()->route('customer.index')->with('message', ['type' => 'success', 'msg' => 'Thay đổi trạng thái thành công!']);
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function restore($id)
    {

        $customer = User::find($id);
        if ($customer == null) {
            return redirect()->route('customer.trash')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }

        $customer->status = 2;
        $customer->updated_at = date('Y-m-d H:i:s');
        $customer->updated_by = Auth::guard('admin')->user()->id;
        $customer->save();
        return redirect()->route('customer.index')->with('message', ['type' => 'success', 'msg' => 'Phục hồi thành công!']);
    }
    public function trash_multi(Request $request)
    {
        $path = 'images/user/';

        if (isset($request['DELETE_ALL'])) {
            if (isset($request->checkId)) {
                $list_id = $request->input('checkId');
                $count_max = sizeof($list_id);
                $count = 0;
                foreach ($list_id as $id) {
                    $customer = User::find($id);
                    if ($customer == null) {
                        return redirect()->route('customer.trash')->with('message', ['type' => 'danger', 'msg' => "Có mẫu tin không tồn tại!&&Đã xóa $count/$count_max !"]);
                    }
                    if ($customer->delete()) {
                        if (File::exists(public_path($path . $customer->image)) && ($customer->image != 'user_women.jpg') && ($customer->image != 'user_men.jpg')) {
                            File::delete(public_path($path . $customer->image));
                        }
                        $count++;
                    }
                }
                return redirect()->route('customer.trash')->with('message', ['type' => 'success', 'msg' => "Xóa vĩnh viễn thành công $count/$count_max !"]);
            } else {
                return redirect()->route('customer.trash')->with('message', ['type' => 'danger', 'msg' => 'Chưa chọn mẫu tin!']);
            }
        }
        if (isset($request['RESTORE_ALL'])) {
            if (isset($request->checkId)) {
                $list_id = $request->input('checkId');
                $count_max = sizeof($list_id);
                $count = 0;
                foreach ($list_id as $id) {
                    $customer = User::find($id);
                    if ($customer == null) {
                        return redirect()->route('customer.trash')->with('message', ['type' => 'danger', 'msg' => "Có mẫu tin không tồn tại!&&Đã phục hồi $count/$count_max !"]);
                    }

                    $customer->status = 2;
                    $customer->updated_at = date('Y-m-d H:i:s');
                    $customer->updated_by = Auth::guard('admin')->user()->id;
                    $customer->save();
                    $count++;
                }
                return redirect()->route('customer.index')->with('message', ['type' => 'success', 'msg' => "Phục hồi thành công $count/$count_max !"]);
            } else {
                return redirect()->route('customer.trash')->with('message', ['type' => 'danger', 'msg' => 'Chưa chọn mẫu tin!']);
            }
        }
    }
}
