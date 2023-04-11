<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandStoreRequest;
use App\Http\Requests\BrandUpdateRequest;
use App\Models\Brand;
use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brand = Brand::where('status', '!=', '0')
            ->orderBy('created_at', 'desc')
            ->get();
        $title = 'Tất Cả Thương Hiệu';
        return view("backend.brand.index", compact('brand', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Thêm Thương Hiệu';
        $brand = Brand::where('status', '!=', '0')
            ->get();
        $html_sort_order = "";
        foreach ($brand as $item) {
            $html_sort_order .= "<option value='" . ($item->sort_order + 1) . "'" . (($item->sort_order + 1 == old('sort_order')) ? ' selected ' : ' ') . " >Sau: " . $item->name . "</option>";
        }
        return view("backend.brand.create", compact('title', 'html_sort_order'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandStoreRequest $request)
    {
        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name, '-');
        $brand->metakey = $request->metakey;
        $brand->metadesc = $request->metadesc;
        $brand->sort_order = $request->sort_order;
        // $brand->level = 1;
        $brand->status = $request->status;
        $brand->created_at = date('Y-m-d H:i:s');
        $brand->created_by = Auth::guard('admin')->user()->id;
        //upload file

        if ($request->hasFile('image')) {
            $path = 'images/brand/';
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = $brand->slug . '.' . $extension;
            $file->move($path, $filename);
            $brand->image = $filename;
        }
        if ($brand->save()) {
            $link = new Link();
            $link->slug = $brand->slug;
            $link->table_id = $brand->id;
            $link->type = 'brand';
            $link->save();
            return redirect()->route('brand.index')->with('message', ['type' => 'success', 'msg' => 'Thêm thành công!']);
        }

        return redirect()->route('brand.create')->with('message', ['type' => 'danger', 'msg' => 'Thêm thất bại!!']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $brand = Brand::find($id);
        if ($brand == null) {
            return redirect()->route('brand.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại']);
        }
        $title = 'Chi Tiết Thương Hiệu';
        return view("backend.brand.show", compact('title', 'brand'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $brand = Brand::where([['status', '!=', '0'], ['id', '=', $id]])->first();
        if ($brand == null) {
            return redirect()->route('brand.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại']);
        }
        $title = 'Sửa Thương Hiệu';
        $list = Brand::where([['status', '!=', '0'], ['id', '!=', $id]])
            ->orderBy('created_at', 'desc')->get();

        $html_sort_order = "";
        foreach ($list as $item) {

            $html_sort_order .= "<option value='" . ($item->sort_order + 1) . "'" . (($item->sort_order + 1 == old('sort_order', $brand->sort_order)) ? ' selected ' : ' ') . ">Sau: " . $item->name . "</option>";
        }
        return view("backend.brand.edit", compact('title', 'html_sort_order', 'brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandUpdateRequest $request, $id)
    {
        $request->validate([
            'name' => [
                Rule::unique('brand', 'name')->ignore($id),
                Rule::unique('product', 'name'),
                Rule::unique('category', 'name'),
                Rule::unique('topic', 'name'),
                Rule::unique('post', 'title'),
            ]
        ], [
            'name.unique' => 'Tên đã được sử dụng. Vui lòng chọn tên khác.'
        ]);
        $brand = Brand::find($id);
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name, '-');
        $brand->metakey = $request->metakey;
        $brand->metadesc = $request->metadesc;
        $brand->sort_order = $request->sort_order;
        // $brand->level = 1;
        $brand->status = $request->status;
        $brand->updated_at = date('Y-m-d H:i:s');
        $brand->updated_by = Auth::guard('admin')->user()->id;
        //upload file

        if ($request->hasFile('image')) {
            $path = 'images/brand/';
            if (File::exists(public_path($path . $brand->image))) {
                File::delete(public_path($path . $brand->image));
            }
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = $brand->slug . '.' . $extension;
            $file->move($path, $filename);
            $brand->image = $filename;
        }
        if ($brand->save()) {
            if ($brand->status == 2) {
                $brand->product()->update([
                    'status' => 2,
                    'updated_by' => Auth::guard('admin')->user()->id
                ]);
                $brand->menu()->update([
                    'status' => 2,
                    'updated_by' => Auth::guard('admin')->user()->id
                ]);
            }
            $brand->link()->update(['slug' => $brand->slug]);
            $brand->menu()->update([
                'name' => $brand->name,
                'link' => $brand->slug,
                'updated_by' => Auth::guard('admin')->user()->id
            ]);
            return redirect()->route('brand.index')->with('message', ['type' => 'success', 'msg' => 'Cập nhật thành công!']);
        }
        return redirect()->route('brand.edit')->with('message', ['type' => 'danger', 'msg' => 'Cập nhật thất bại!!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $brand = Brand::find($id);
        if ($brand == null) {
            return redirect()->route('brand.trash')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }
        if ($brand->delete()) {

            $brand->product()->update([
                'status' => 0,
                'updated_by' => Auth::guard('admin')->user()->id
            ]);
            $brand->menu()->delete();
            $brand->link()->delete();
            $path = 'images/brand/';
            if (File::exists(public_path($path . $brand->image))) {
                File::delete(public_path($path . $brand->image));
            }
            return redirect()->route('brand.trash')->with('message', ['type' => 'success', 'msg' => 'Xóa vĩnh viễn thành công!']);
        }
        return redirect()->route('brand.trash')->with('message', ['type' => 'danger', 'msg' => 'Xóa thất bại!']);
    }

    public function trash()
    {
        //$list=Product::all();//try van tat ca
        $brand = Brand::where('status', '=', 0)->Orderby('updated_at', 'asc')->get();
        $title = 'Thùng rác thương hiệu';
        return view("backend.brand.trash", compact('brand', 'title'));
    }

    public function trash_multi(Request $request)
    {
        $path = 'images/brand/';

        if (isset($request['DELETE_ALL'])) {
            if (isset($request->checkId)) {
                $list_id = $request->input('checkId');
                $count_max = sizeof($list_id);
                $count = 0;
                foreach ($list_id as $id) {
                    $brand = Brand::find($id);
                    if ($brand == null) {
                        return redirect()->route('brand.trash')->with('message', ['type' => 'danger', 'msg' => "Có mẫu tin không tồn tại!&&Đã xóa $count/$count_max !"]);
                    }
                    if ($brand->delete()) {
                        if (File::exists(public_path($path . $brand->image))) {
                            File::delete(public_path($path . $brand->image));
                        }
                        $brand->product()->update([
                            'status' => 0,
                            'updated_by' => Auth::guard('admin')->user()->id
                        ]);
                        $brand->menu()->delete();
                        $brand->link()->delete();
                        $count++;
                    }
                }
                return redirect()->route('brand.trash')->with('message', ['type' => 'success', 'msg' => "Xóa vĩnh viễn thành công $count/$count_max !"]);
            } else {
                return redirect()->route('brand.trash')->with('message', ['type' => 'danger', 'msg' => 'Chưa chọn mẫu tin!']);
            }
        }
        if (isset($request['RESTORE_ALL'])) {
            if (isset($request->checkId)) {
                $list_id = $request->input('checkId');
                $count_max = sizeof($list_id);
                $count = 0;
                foreach ($list_id as $id) {
                    $brand = Brand::find($id);
                    if ($brand == null) {
                        return redirect()->route('brand.trash')->with('message', ['type' => 'danger', 'msg' => "Có mẫu tin không tồn tại!&&Đã phục hồi $count/$count_max !"]);
                    }

                    $brand->status = 2;
                    $brand->updated_at = date('Y-m-d H:i:s');
                    $brand->updated_by = Auth::guard('admin')->user()->id;
                    $brand->save();
                    $count++;
                }
                return redirect()->route('brand.index')->with('message', ['type' => 'success', 'msg' => "Phục hồi thành công $count/$count_max !"]);
            } else {
                return redirect()->route('brand.trash')->with('message', ['type' => 'danger', 'msg' => 'Chưa chọn mẫu tin!']);
            }
        }
    }

    public function delete($id)
    {
        $brand = Brand::find($id);
        if ($brand == null) {
            return redirect()->route('brand.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }
        $brand->status = 0;
        $brand->updated_at = date('Y-m-d H:i:s');
        $brand->updated_by = Auth::guard('admin')->user()->id;
        if ($brand->save()) {
            if ($brand->status == 0) {
                $brand->product()->update([
                    'status' => 0,
                    'updated_by' => Auth::guard('admin')->user()->id
                ]);
                $brand->menu()->update([
                    'status' => 0,
                    'updated_by' => Auth::guard('admin')->user()->id
                ]);
            }
            return redirect()->route('brand.index')->with('message', ['type' => 'success', 'msg' => 'Xóa thành công!&& vào thùng rác để xem!!!']);
        }
    }
    public function delete_multi(Request $request)
    {
        if (isset($request->checkId)) {
            $list_id = $request->input('checkId');
            $count_max = sizeof($list_id);
            $count = 0;
            foreach ($list_id as $id) {

                $brand = Brand::find($id);
                if ($brand == null) {
                    return redirect()->route('brand.index')->with('message', ['type' => 'danger', 'msg' => "Có mẫu tin không tồn tại!Đã xóa $count/$count_max ! "]);
                }
                $brand->status = 0;
                $brand->updated_at = date('Y-m-d H:i:s');
                $brand->updated_by = Auth::guard('admin')->user()->id;
                $brand->save();
                if ($brand->status == 0) {
                    $brand->product()->update([
                        'status' => 0,
                        'updated_by' => Auth::guard('admin')->user()->id
                    ]);
                    $brand->menu()->update([
                        'status' => 0,
                        'updated_by' => Auth::guard('admin')->user()->id
                    ]);
                }
                $count++;
            }
            return redirect()->route('brand.index')->with('message', ['type' => 'success', 'msg' => "Xóa thành công $count/$count_max !&& Vào thùng rác để xem!!!"]);
        } else {
            return redirect()->route('brand.index')->with('message', ['type' => 'danger', 'msg' => 'Chưa chọn mẫu tin!']);
        }
    }

    public function status($id)
    {

        $brand = Brand::find($id);
        if ($brand == null) {
            return redirect()->route('brand.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }

        $brand->status = ($brand->status == 1) ? 2 : 1;
        $brand->updated_at = date('Y-m-d H:i:s');
        $brand->updated_by = Auth::guard('admin')->user()->id;
        if ($brand->save()) {
            if ($brand->status == 2) {
                $brand->product()->update([
                    'status' => 2,
                    'updated_by' => Auth::guard('admin')->user()->id
                ]);
                $brand->menu()->update([
                    'status' => 2,
                    'updated_by' => Auth::guard('admin')->user()->id
                ]);
            }
            return redirect()->route('brand.index')->with('message', ['type' => 'success', 'msg' => 'Thay đổi trạng thái thành công!']);
        }
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function restore($id)
    {

        $brand = Brand::find($id);
        if ($brand == null) {
            return redirect()->route('brand.trash')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }

        $brand->status = 2;
        $brand->updated_at = date('Y-m-d H:i:s');
        $brand->updated_by = Auth::guard('admin')->user()->id;
        $brand->save();
        return redirect()->route('brand.index')->with('message', ['type' => 'success', 'msg' => 'Phục hồi thành công!']);
    }
}
