<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use App\Models\Link;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::where('status', '!=', '0')
            ->orderBy('created_at', 'desc')
            ->get();
        $title = 'Tất Cả Danh Mục';
        return view("backend.category.index", compact('category', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Thêm Danh Mục';
        $category = Category::where('status', '!=', '0')
            ->get();
        $html_sort_order = "";
        $html_parent_id = "";

        foreach ($category as $item) {
            $html_sort_order .= "<option value='" . ($item->sort_order + 1) . "'" . (($item->sort_order + 1 == old('sort_order')) ? ' selected ' : ' ') . " >Sau: " . $item->name . "</option>";

            $html_parent_id .= "<option value='" . $item->id . "'" . (($item->id == old('parent_id')) ? ' selected ' : ' ') . ">" . $item->name . "</option>";
        }
        return view("backend.category.create", compact('title', 'html_sort_order', 'html_parent_id'));
    }
    public function status($id)
    {

        $category = Category::find($id);
        if ($category == null) {
            return redirect()->route('category.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }

        $category->status = ($category->status == 1) ? 2 : 1;

        $category->updated_at = date('Y-m-d H:i:s');
        $category->updated_by = Auth::guard('admin')->user()->id;
        if ($category->save()) {
            if ($category->status == 2) {
                $category->product()->update([
                    'status' => 2,
                    'updated_by' => Auth::guard('admin')->user()->id
                ]);
                $category->menu()->update([
                    'status' => 2,
                    'updated_by' => Auth::guard('admin')->user()->id
                ]);
            }
            return redirect()->route('category.index')->with('message', ['type' => 'success', 'msg' => 'Thay đổi trạng thái thành công!']);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name, '-');
        $category->metakey = $request->metakey;
        $category->metadesc = $request->metadesc;
        $category->sort_order = $request->sort_order;
        $category->parent_id = $request->parent_id;
        $category->level = 1;
        $category->status = $request->status;
        $category->created_at = date('Y-m-d H:i:s');
        $category->created_by = Auth::guard('admin')->user()->id;
        //upload file

        if ($category->save()) {
            $link = new Link();
            $link->slug = $category->slug;
            $link->table_id = $category->id;
            $link->type = 'category';
            $link->save();
            return redirect()->route('category.index')->with('message', ['type' => 'success', 'msg' => 'Thêm thành công!']);
        }

        return redirect()->route('category.create')->with('message', ['type' => 'danger', 'msg' => 'Thêm thất bại!!']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = Category::find($id);
        if ($category == null) {
            return redirect()->route('category.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại']);
        }
        $title = 'Chi Tiết Danh Mục';
        return view("backend.category.show", compact('title', 'category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $title = 'Sửa Danh Mục';
        $category = Category::where([['status', '!=', '0'], ['id', '=', $id]])->first();
        if ($category == null) {
            return redirect()->route('category.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }
        $list = Category::where([['status', '!=', '0'], ['id', '!=', $id]])
            ->orderBy('created_at', 'desc')->get();

        $html_sort_order = "";
        $html_parent_id = "";
        foreach ($list as $item) {

            $html_sort_order .= "<option value='" . ($item->sort_order + 1) . "'" . (($item->sort_order + 1 == old('sort_order', $category->sort_order)) ? ' selected ' : ' ') . ">Sau: " . $item->name . "</option>";
            $html_parent_id .= "<option value='" . $item->id . "'" . (($item->id == old('parent_id', $category->parent_id)) ? ' selected ' : ' ') . ">" . $item->name . "</option>";
        }
        return view("backend.category.edit", compact('title', 'html_sort_order', 'category', 'html_parent_id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, $id)
    {
        $request->validate([
            'name' => [
                Rule::unique('category', 'name')->ignore($id),
                Rule::unique('product', 'name'),
                Rule::unique('brand', 'name'),
                Rule::unique('topic', 'name'),
                Rule::unique('post', 'title'),
            ]
        ], [
            'name.unique' => 'Tên đã được sử dụng. Vui lòng chọn tên khác.'
        ]);
        $category = Category::find($id);
        $category->name = $request->name;
        $category->slug = Str::slug($request->name, '-');
        $category->metakey = $request->metakey;
        $category->metadesc = $request->metadesc;
        $category->sort_order = $request->sort_order;
        $category->parent_id = $request->parent_id;
        $category->level = 1;
        $category->status = $request->status;
        $category->updated_at = date('Y-m-d H:i:s');
        $category->updated_by = Auth::guard('admin')->user()->id;
        //upload file

        if ($category->save()) {
            if ($category->status == 2) {
                $category->product()->update([
                    'status' => 2,
                    'updated_by' => Auth::guard('admin')->user()->id
                ]);
                $category->menu()->update([
                    'status' => 2,
                    'updated_by' => Auth::guard('admin')->user()->id
                ]);
            }
            $category->link()->update([
                'slug' => $category->slug,
            ]);
            $category->menu()->update([
                'name' => $category->name,

                'link' => $category->slug,
                'updated_by' => Auth::guard('admin')->user()->id
            ]);
            return redirect()->route('category.index')->with('message', ['type' => 'success', 'msg' => 'Cập nhật thành công!']);
        }
        return redirect()->route('category.edit')->with('message', ['type' => 'danger', 'msg' => 'Cập nhật thất bại!!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if ($category == null) {
            return redirect()->route('category.trash')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }
        if ($category->delete()) {
            $category->product()->update([
                'status' => 0,
                'updated_by' => Auth::guard('admin')->user()->id
            ]);
            $category->menu()->delete();
            $category->link()->delete();
            return redirect()->route('category.trash')->with('message', ['type' => 'success', 'msg' => 'Xóa vĩnh viễn thành công!']);
        }
        return redirect()->route('category.trash')->with('message', ['type' => 'danger', 'msg' => 'Xóa thất bại!']);
    }
    public function delete($id)
    {
        $category = Category::find($id);
        if ($category == null) {
            return redirect()->route('category.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }
        $category->status = 0;
        $category->updated_at = date('Y-m-d H:i:s');
        $category->updated_by = Auth::guard('admin')->user()->id;
        if ($category->save()) {
            if ($category->status == 0) {
                $category->product()->update([
                    'status' => 0,
                    'updated_by' => Auth::guard('admin')->user()->id
                ]);
                $category->menu()->update([
                    'status' => 0,
                    'updated_by' => Auth::guard('admin')->user()->id
                ]);
            }
            return redirect()->route('category.index')->with('message', ['type' => 'success', 'msg' => 'Xóa thành công!&& vào thùng rác để xem!!!']);
        }
    }
    public function delete_multi(Request $request)
    {
        if (isset($request->checkId)) {
            $list_id = $request->input('checkId');
            $count_max = sizeof($list_id);
            $count = 0;
            foreach ($list_id as $id) {
                $category = Category::find($id);
                if ($category == null) {
                    return redirect()->route('category.index')->with('message', ['type' => 'danger', 'msg' => "Có mẫu tin không tồn tại!Đã xóa $count/$count_max ! "]);
                }
                $category->status = 0;
                $category->updated_at = date('Y-m-d H:i:s');
                $category->updated_by = Auth::guard('admin')->user()->id;
                if ($category->save()) {
                    if ($category->status == 0) {
                        $category->product()->update([
                            'status' => 0,
                            'updated_by' => Auth::guard('admin')->user()->id
                        ]);
                        $category->menu()->update([
                            'status' => 0,
                            'updated_by' => Auth::guard('admin')->user()->id
                        ]);
                    }
                }
                $count++;
            }
            return redirect()->route('category.index')->with('message', ['type' => 'success', 'msg' => "Xóa thành công $count/$count_max !&& Vào thùng rác để xem!!!"]);
        } else {
            return redirect()->route('category.index')->with('message', ['type' => 'danger', 'msg' => 'Chưa chọn mẫu tin!']);
        }
    }
    public function trash()
    {
        //$list=Product::all();//try van tat ca
        $category = Category::where('status', '=', 0)->Orderby('updated_at', 'asc')->get();
        $title = 'Thùng rác danh mục';
        return view("backend.category.trash", compact('category', 'title'));
    }
    public function trash_multi(Request $request)
    {

        if (isset($request['DELETE_ALL'])) {
            if (isset($request->checkId)) {
                $list_id = $request->input('checkId');
                $count_max = sizeof($list_id);
                $count = 0;
                foreach ($list_id as $id) {
                    $category = Category::find($id);
                    if ($category == null) {
                        return redirect()->route('category.trash')->with('message', ['type' => 'danger', 'msg' => "Có mẫu tin không tồn tại!&&Đã xóa $count/$count_max !"]);
                    }
                    if ($category->delete()) {
                        $category->product()->update([
                            'status' => 0,
                            'updated_by' => Auth::guard('admin')->user()->id
                        ]);
                        $category->menu()->delete();
                        $category->link()->delete();
                        $count++;
                    }
                }
                return redirect()->route('category.trash')->with('message', ['type' => 'success', 'msg' => "Xóa vĩnh viễn thành công $count/$count_max !"]);
            } else {
                return redirect()->route('category.trash')->with('message', ['type' => 'danger', 'msg' => 'Chưa chọn mẫu tin!']);
            }
        }
        if (isset($request['RESTORE_ALL'])) {
            if (isset($request->checkId)) {
                $list_id = $request->input('checkId');
                $count_max = sizeof($list_id);
                $count = 0;
                foreach ($list_id as $id) {
                    $category = Category::find($id);
                    if ($category == null) {
                        return redirect()->route('category.trash')->with('message', ['type' => 'danger', 'msg' => "Có mẫu tin không tồn tại!&&Đã phục hồi $count/$count_max !"]);
                    }

                    $category->status = 2;
                    $category->updated_at = date('Y-m-d H:i:s');
                    $category->updated_by = Auth::guard('admin')->user()->id;
                    $category->save();
                    $count++;
                }
                return redirect()->route('category.index')->with('message', ['type' => 'success', 'msg' => "Phục hồi thành công $count/$count_max !"]);
            } else {
                return redirect()->route('category.trash')->with('message', ['type' => 'danger', 'msg' => 'Chưa chọn mẫu tin!']);
            }
        }
    }
    public function restore($id)
    {

        $category = Category::find($id);
        if ($category == null) {
            return redirect()->route('category.trash')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }

        $category->status = 2;
        $category->updated_at = date('Y-m-d H:i:s');
        $category->updated_by = Auth::guard('admin')->user()->id;
        $category->save();
        return redirect()->route('category.index')->with('message', ['type' => 'success', 'msg' => 'Phục hồi thành công!']);
    }
}
