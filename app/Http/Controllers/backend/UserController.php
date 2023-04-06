<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::where([['status', '!=', '0'], ['roles', '!=', '0']])
            ->orderBy('created_at', 'desc')
            ->get();
        $title = 'Tất Cả Thành Viên';
        return view("backend.user.index", compact('user', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Thêm Thành Viên';
        return view("backend.user.create", compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->email = $request->email;
        $user->gender = $request->gender;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->roles = 1;
        // $user->level = 1;
        $user->status = $request->status;
        $user->created_at = date('Y-m-d H:i:s');
        $user->created_by = Auth::guard('admin')->user()->id;
        //upload file

        if ($request->hasFile('image')) {
            $path = 'images/user/';
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = $user->username . '.' . $extension;
            $file->move($path, $filename);
            $user->image = $filename;
        } else {
            if ($user->gender) {
                $user->image = 'user_women.jpg';
            } else {
                $user->image = 'user_men.jpg';
            }
        }
        if ($user->save()) {
            return redirect()->route('user.index')->with('message', ['type' => 'success', 'msg' => 'Thêm thành công!']);
        }
        return redirect()->route('user.create')->with('message', ['type' => 'danger', 'msg' => 'Thêm thất bại!!']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::find($id);
        if ($user == null) {
            return redirect()->route('user.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại']);
        }
        $title = 'Chi Tiết Thành viên';
        return view("backend.user.show", compact('title', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::where([['status', '!=', '0'], ['id', '=', $id], ['roles', '!=', '0']])->first();
        if ($user == null) {
            return redirect()->route('user.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại']);
        }
        $title = 'Sửa Thành Viên';
        return view('backend.user.edit', compact('title', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $request->validate([
            'name' => 'unique:user,name,' . $id . ',id',
            'username' => 'unique:user,username,' . $id . ',id',
        ], [
            'name.unique' => 'Tên đã được sử dụng. Vui lòng chọn tên khác.',
            'username.unique' => 'Tên đã được sử dụng. Vui lòng chọn tên khác.'
        ]);
        $user = User::find($id);
        $user->name = $request->name;
        $user->username = $request->username;
        if ($request->password != null) {
            $user->password = bcrypt($request->password);
        }
        $user->email = $request->email;
        $user->gender = $request->gender;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->roles = 1;
        // $user->level = 1;
        $user->status = $request->status;
        $user->created_at = date('Y-m-d H:i:s');
        $user->created_by = Auth::guard('admin')->user()->id;
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
            return redirect()->route('user.index')->with('message', ['type' => 'success', 'msg' => 'Cập nhật thành công!']);
        }
        return redirect()->route('user.edit')->with('message', ['type' => 'danger', 'msg' => 'Cập nhật thất bại!!']);
    }
    public function trash()
    {
        $user = User::where([['status', '=', '0'], ['roles', '!=', '0']])
            ->orderBy('updated_at', 'asc')
            ->get();
        $title = 'Thùng rác thành viên';
        return view("backend.user.trash", compact('user', 'title'));
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user == null) {
            return redirect()->route('user.trash')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }
        if ($user->delete()) {
            $path = 'images/user/';
            if (File::exists(public_path($path . $user->image)) && ($user->image != 'user_women.jpg') && ($user->image != 'user_men.jpg')) {
                File::delete(public_path($path . $user->image));
            }
            return redirect()->route('user.trash')->with('message', ['type' => 'success', 'msg' => 'Xóa vĩnh viễn thành công!']);
        }
        return redirect()->route('user.trash')->with('message', ['type' => 'danger', 'msg' => 'Xóa thất bại!']);
    }

    public function delete($id)
    {
        $user = User::find($id);
        if ($user == null) {
            return redirect()->route('user.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }
        $user->status = 0;
        $user->updated_at = date('Y-m-d H:i:s');
        $user->updated_by = Auth::guard('admin')->user()->id;
        $user->save();
        return redirect()->route('user.index')->with('message', ['type' => 'success', 'msg' => 'Xóa thành công!&& vào thùng rác để xem!!!']);
    }

    public function delete_multi(Request $request)
    {
        if (isset($request->checkId)) {
            $list_id = $request->input('checkId');
            $count_max = sizeof($list_id);
            $count = 0;
            foreach ($list_id as $id) {
                $user = User::find($id);
                if ($user == null) {
                    return redirect()->route('user.index')->with('message', ['type' => 'danger', 'msg' => "Có mẫu tin không tồn tại!Đã xóa $count/$count_max ! "]);
                }
                $user->status = 0;
                $user->updated_at = date('Y-m-d H:i:s');
                $user->updated_by = Auth::guard('admin')->user()->id;
                $user->save();
                $count++;
            }
            return redirect()->route('user.index')->with('message', ['type' => 'success', 'msg' => "Xóa thành công $count/$count_max !&& Vào thùng rác để xem!!!"]);
        } else {
            return redirect()->route('user.index')->with('message', ['type' => 'danger', 'msg' => 'Chưa chọn mẫu tin!']);
        }
    }

    public function status($id)
    {

        $user = User::find($id);
        if ($user == null) {
            return redirect()->route('user.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }

        $user->status = ($user->status == 1) ? 2 : 1;
        $user->updated_at = date('Y-m-d H:i:s');
        $user->updated_by = Auth::guard('admin')->user()->id;
        $user->save();
        return redirect()->route('user.index')->with('message', ['type' => 'success', 'msg' => 'Thay đổi trạng thái thành công!']);
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function restore($id)
    {

        $user = User::find($id);
        if ($user == null) {
            return redirect()->route('user.trash')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }

        $user->status = 2;
        $user->updated_at = date('Y-m-d H:i:s');
        $user->updated_by = Auth::guard('admin')->user()->id;
        $user->save();
        return redirect()->route('user.index')->with('message', ['type' => 'success', 'msg' => 'Phục hồi thành công!']);
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
                    $user = User::find($id);
                    if ($user == null) {
                        return redirect()->route('user.trash')->with('message', ['type' => 'danger', 'msg' => "Có mẫu tin không tồn tại!&&Đã xóa $count/$count_max !"]);
                    }
                    if ($user->delete()) {
                        if (File::exists(public_path($path . $user->image)) && ($user->image != 'user_women.jpg') && ($user->image != 'user_men.jpg')) {
                            File::delete(public_path($path . $user->image));
                        }
                        $count++;
                    }
                }
                return redirect()->route('user.trash')->with('message', ['type' => 'success', 'msg' => "Xóa vĩnh viễn thành công $count/$count_max !"]);
            } else {
                return redirect()->route('user.trash')->with('message', ['type' => 'danger', 'msg' => 'Chưa chọn mẫu tin!']);
            }
        }
        if (isset($request['RESTORE_ALL'])) {

            if (isset($request->checkId)) {
                $list_id = $request->input('checkId');
                $count_max = sizeof($list_id);
                $count = 0;
                foreach ($list_id as $id) {
                    $user = User::find($id);
                    if ($user == null) {
                        return redirect()->route('user.trash')->with('message', ['type' => 'danger', 'msg' => "Có mẫu tin không tồn tại!&&Đã phục hồi $count/$count_max !"]);
                    }

                    $user->status = 2;
                    $user->updated_at = date('Y-m-d H:i:s');
                    $user->updated_by = Auth::guard('admin')->user()->id;
                    $user->save();
                    $count++;
                }
                return redirect()->route('user.index')->with('message', ['type' => 'success', 'msg' => "Phục hồi thành công $count/$count_max !"]);
            } else {
                return redirect()->route('user.trash')->with('message', ['type' => 'danger', 'msg' => 'Chưa chọn mẫu tin!']);
            }
        }
    }
}
