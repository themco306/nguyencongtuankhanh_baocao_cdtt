<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\PageStoreRequest;
use App\Http\Requests\PageUpdateRequest;
use App\Models\Link;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page = Post::where([['status', '!=', '0'], ['type', '=', 'page']])
            ->orderBy('created_at', 'desc')
            ->get();
        $title = 'Tất Cả Trang Đơn';
        return view("backend.page.index", compact('page', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Thêm Trang Đơn';
        return view("backend.page.create", compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PageStoreRequest $request)
    {
        $page = new Post();
        $page->title = $request->title;
        $page->slug = Str::slug($request->title, '-');
        $page->metakey = $request->metakey;
        $page->metadesc = $request->metadesc;
        $page->detail = $request->detail;
        $page->status = $request->status;
        $page->type = 'page';
        $page->created_at = date('Y-m-d H:i:s');
        $page->created_by = Auth::guard('admin')->user()->id;
        //upload file

        if ($request->hasFile('image')) {
            $path = 'images/post/';
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = $page->slug . '.' . $extension;
            $file->move($path, $filename);
            $page->image = $filename;
        }
        if ($page->save()) {
            $link = new Link();
            $link->slug = $page->slug;
            $link->table_id = $page->id;
            $link->type = 'page';
            $link->save();
            return redirect()->route('page.index')->with('message', ['type' => 'success', 'msg' => 'Thêm thành công!']);
        }
        return redirect()->route('page.create')->with('message', ['type' => 'danger', 'msg' => 'Thêm thất bại!!']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $page = Post::find($id);
        if ($page == null) {
            return redirect()->route('page.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại']);
        }
        $title = 'Chi Tiết Trang đơn';
        return view("backend.page.show", compact('title', 'page'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $title = 'Sửa Trang Đơn';
        $page = Post::where([['status', '!=', '0'], ['id', '=', $id]])->first();
        if ($page == null) {
            return redirect()->route('page.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại']);
        }
        return view("backend.page.edit", compact('title', 'page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PageUpdateRequest $request, $id)
    {
        $request->validate([
            'title' => [
                Rule::unique('post', 'title')->ignore($id),
                Rule::unique('product', 'name'),
                Rule::unique('brand', 'name'),
                Rule::unique('category', 'name'),
                Rule::unique('topic', 'name'),
            ]
        ], [
            'name.unique' => 'Tên đã được sử dụng. Vui lòng chọn tên khác.'
        ]);
        $page = Post::find($id);
        $page->title = $request->title;
        $page->slug = Str::slug($request->title, '-');
        $page->metakey = $request->metakey;
        $page->metadesc = $request->metadesc;
        $page->detail = $request->detail;
        $page->status = $request->status;

        $page->updated_at = date('Y-m-d H:i:s');
        $page->updated_by = Auth::guard('admin')->user()->id;
        //upload file

        if ($request->hasFile('image')) {
            $path = 'images/post/';
            if (File::exists(public_path($path . $page->image))) {
                File::delete(public_path($path . $page->image));
            }
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = $page->slug . '.' . $extension;
            $file->move($path, $filename);
            $page->image = $filename;
        }
        if ($page->save()) {
            if ($page->status == 2) {
                $page->menu()->update([
                    'status' => 2,
                    'updated_by' => Auth::guard('admin')->user()->id
                ]);
            }
            $page->link()->update([
                'slug' => $page->slug,
            ]);
            $page->menu()->update([
                'name' => $page->title,

                'link' => $page->slug,
                'updated_by' => Auth::guard('admin')->user()->id
            ]);
            return redirect()->route('page.index')->with('message', ['type' => 'success', 'msg' => 'Cập nhật thành công!']);
        }
        return redirect()->route('page.edit')->with('message', ['type' => 'danger', 'msg' => 'Cập nhật thất bại!!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $page = Post::find($id);
        if ($page == null) {
            return redirect()->route('page.trash')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }
        if ($page->delete()) {
            $path = 'images/post/';
            if (File::exists(public_path($path . $page->image))) {
                File::delete(public_path($path . $page->image));
            }

            $page->menu()->delete();
            $page->link()->delete();
            return redirect()->route('page.trash')->with('message', ['type' => 'success', 'msg' => 'Xóa vĩnh viễn thành công!']);
        }
        return redirect()->route('page.trash')->with('message', ['type' => 'danger', 'msg' => 'Xóa thất bại!']);
    }

    public function trash()
    {
        //$list=Product::all();//try van tat ca
        $page = Post::where([['status', '=', '0'], ['type', '=', 'page']])->Orderby('updated_at', 'asc')->get();
        $title = 'Thùng rác trang đơn';
        return view("backend.page.trash", compact('page', 'title'));
    }

    public function trash_multi(Request $request)
    {
        $path = 'images/post/';

        if (isset($request['DELETE_ALL'])) {
            if (isset($request->checkId)) {
                $list_id = $request->input('checkId');
                $count_max = sizeof($list_id);
                $count = 0;
                foreach ($list_id as $id) {
                    $page = Post::find($id);
                    if ($page == null) {
                        return redirect()->route('page.trash')->with('message', ['type' => 'danger', 'msg' => "Có mẫu tin không tồn tại!&&Đã xóa $count/$count_max !"]);
                    }
                    if ($page->delete()) {
                        if (File::exists(public_path($path . $page->image))) {
                            File::delete(public_path($path . $page->image));
                        }

                        $page->menu()->delete();
                        $page->link()->delete();
                        $count++;
                    }
                }
                return redirect()->route('page.trash')->with('message', ['type' => 'success', 'msg' => "Xóa vĩnh viễn thành công $count/$count_max !"]);
            } else {
                return redirect()->route('page.trash')->with('message', ['type' => 'danger', 'msg' => 'Chưa chọn mẫu tin!']);
            }
        }
        if (isset($request['RESTORE_ALL'])) {
            if (isset($request->checkId)) {
                $list_id = $request->input('checkId');
                $count_max = sizeof($list_id);
                $count = 0;
                foreach ($list_id as $id) {
                    $page = Post::find($id);
                    if ($page == null) {
                        return redirect()->route('page.trash')->with('message', ['type' => 'danger', 'msg' => "Có mẫu tin không tồn tại!&&Đã phục hồi $count/$count_max !"]);
                    }

                    $page->status = 2;
                    $page->updated_at = date('Y-m-d H:i:s');
                    $page->updated_by = Auth::guard('admin')->user()->id;
                    $page->save();
                    $count++;
                }
                return redirect()->route('page.index')->with('message', ['type' => 'success', 'msg' => "Phục hồi thành công $count/$count_max !"]);
            } else {
                return redirect()->route('page.trash')->with('message', ['type' => 'danger', 'msg' => 'Chưa chọn mẫu tin!']);
            }
        }
    }

    public function delete($id)
    {
        $page = Post::find($id);
        if ($page == null) {
            return redirect()->route('page.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }
        $page->status = 0;
        $page->updated_at = date('Y-m-d H:i:s');
        $page->updated_by = Auth::guard('admin')->user()->id;
        if ($page->save()) {
            if ($page->status == 0) {
                $page->menu()->update([
                    'status' => 0,
                    'updated_by' => Auth::guard('admin')->user()->id
                ]);
            }
            return redirect()->route('page.index')->with('message', ['type' => 'success', 'msg' => 'Xóa thành công!&& vào thùng rác để xem!!!']);
        }
    }
    public function delete_multi(Request $request)
    {
        if (isset($request->checkId)) {
            $list_id = $request->input('checkId');
            $count_max = sizeof($list_id);
            $count = 0;
            foreach ($list_id as $id) {
                $page = Post::find($id);
                if ($page == null) {
                    return redirect()->route('page.index')->with('message', ['type' => 'danger', 'msg' => "Có mẫu tin không tồn tại!Đã xóa $count/$count_max ! "]);
                }
                $page->status = 0;
                $page->updated_at = date('Y-m-d H:i:s');
                $page->updated_by = Auth::guard('admin')->user()->id;
                if ($page->save()) {
                    if ($page->status == 0) {
                        $page->menu()->update([
                            'status' => 0,
                            'updated_by' => Auth::guard('admin')->user()->id
                        ]);
                    }
                }
                $count++;
            }
            return redirect()->route('page.index')->with('message', ['type' => 'success', 'msg' => "Xóa thành công $count/$count_max !&& Vào thùng rác để xem!!!"]);
        } else {
            return redirect()->route('page.index')->with('message', ['type' => 'danger', 'msg' => 'Chưa chọn mẫu tin!']);
        }
    }

    public function status($id)
    {

        $page = Post::find($id);
        if ($page == null) {
            return redirect()->route('page.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }

        $page->status = ($page->status == 1) ? 2 : 1;
        $page->updated_at = date('Y-m-d H:i:s');
        $page->updated_by = Auth::guard('admin')->user()->id;
        if ($page->save()) {
            if ($page->status == 2) {
                $page->menu()->update([
                    'status' => 2,
                    'updated_by' => Auth::guard('admin')->user()->id
                ]);
            }
            return redirect()->route('page.index')->with('message', ['type' => 'success', 'msg' => 'Thay đổi trạng thái thành công!']);
        }
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function restore($id)
    {

        $page = Post::find($id);
        if ($page == null) {
            return redirect()->route('page.trash')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }

        $page->status = 2;
        $page->updated_at = date('Y-m-d H:i:s');
        $page->updated_by = Auth::guard('admin')->user()->id;
        $page->save();
        return redirect()->route('page.index')->with('message', ['type' => 'success', 'msg' => 'Phục hồi thành công!']);
    }
}
