<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Http\Requests\SliderStoreRequest;
use App\Http\Requests\SliderUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $slider = Slider::where('status', '!=', '0')
            ->orderBy('created_at', 'desc')
            ->get();
        $title = 'Tất Cả Slider';
        return view("backend.slider.index", compact('slider', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $list = Slider::where('status',  '!=', '0')
            ->get();
        $html_sort_order = "";
        foreach ($list as $item) {
            $html_sort_order .= "<option value='" . ($item->sort_order + 1) . "'" . (($item->sort_order + 1 == old('sort_order')) ? ' selected ' : ' ') . " >Sau: " . $item->name . "</option>";
        }
        $title = 'Thêm Slider';

        return view("backend.slider.create", compact('html_sort_order', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SliderStoreRequest $request)
    {
        $slider = new Slider();
        $slider->name = $request->name;
        $slider->link = $request->link;
        $slider->position = $request->position;
        $slider->sort_order = $request->sort_order;
        // $slider->level = 1;
        $slider->status = $request->status;
        $slider->created_at = date('Y-m-d H:i:s');
        $slider->created_by = Auth::guard('admin')->user()->id;
        //upload file

        if ($request->hasFile('image')) {
            $path = 'images/slider/';
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = Str::slug($request->name, '-') . '.' . $extension;
            $file->move($path, $filename);
            $slider->image = $filename;
        }
        if ($slider->save()) {
            // $link = new Link();
            // $link->slug = $slider->slug;
            // $link->table_id = $slider->id;
            // $link->type = 'slider';
            // $link->save();
            return redirect()->route('slider.index')->with('message', ['type' => 'success', 'msg' => 'Thêm thành công!']);
        }

        return redirect()->route('slider.create')->with('message', ['type' => 'danger', 'msg' => 'Thêm thất bại!!']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $slider = Slider::find($id);
        if ($slider == null) {
            return redirect()->route('slider.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại']);
        }
        $title = 'Chi Tiết Slider';
        return view("backend.slider.show", compact('title', 'slider'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $slider = Slider::find($id);
        if ($slider == null) {
            return redirect()->route('slider.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại']);
        }
        $list = Slider::where([['status', '!=', 0], ['id', '!=', $id]])->get();
        $html_sort_order = "";
        foreach ($list as $item) {
            $html_sort_order .= "<option value='" . ($item->sort_order + 1) . "'" . (($item->sort_order + 1 == old('sort_order', $slider->sort_order)) ? ' selected ' : ' ') . ">Sau: " . $item->name . "</option>";
        }
        $title = 'Sửa Slider';

        return view("backend.slider.edit", compact('title', 'html_sort_order', 'slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SliderUpdateRequest $request, $id)
    {
        $request->validate([
            'name' => 'unique:slider,name,' . $id . ',id',
        ], [
            'name.unique' => 'Tên đã được sử dụng. Vui lòng chọn tên khác.'
        ]);
        $slider = Slider::find($id);
        $slider->name = $request->name;
        $slider->link = $request->link;
        $slider->position = $request->position;
        $slider->sort_order = $request->sort_order;
        // $slider->level = 1;
        $slider->status = $request->status;
        $slider->updated_at = date('Y-m-d H:i:s');
        $slider->updated_by = Auth::guard('admin')->user()->id;
        //upload file

        if ($request->hasFile('image')) {
            $path = 'images/slider/';
            if (File::exists(public_path($path . $slider->image))) {
                File::delete(public_path($path . $slider->image));
            }
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = Str::slug($request->name, '-') . '.' . $extension;
            $file->move($path, $filename);
            $slider->image = $filename;
        }
        if ($slider->save()) {
            // $link = Link::where([['type', '=', 'slider'], ['table_id', '=', $slider->id]])->first();
            // $link->slug = $slider->slug;
            // $link->save();
            return redirect()->route('slider.index')->with('message', ['type' => 'success', 'msg' => 'Cập nhật thành công!']);
        }
        return redirect()->route('slider.edit')->with('message', ['type' => 'danger', 'msg' => 'Cập nhật thất bại!!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $slider = Slider::find($id);
        if ($slider == null) {
            return redirect()->route('slider.trash')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }
        if ($slider->delete()) {
            $path = 'images/slider/';
            if (File::exists(public_path($path . $slider->image))) {
                File::delete(public_path($path . $slider->image));
            }
            return redirect()->route('slider.trash')->with('message', ['type' => 'success', 'msg' => 'Xóa vĩnh viễn thành công!']);
        }
        return redirect()->route('slider.trash')->with('message', ['type' => 'danger', 'msg' => 'Xóa thất bại!']);
    }
    public function trash()
    {
        //$list=Product::all();//try van tat ca
        $slider = Slider::where('status', '=', 0)->Orderby('updated_at', 'asc')->get();
        $title = 'Thùng rác Slider';
        return view("backend.slider.trash", compact('slider', 'title'));
    }
    public function trash_multi(Request $request)
    {
        $path = 'images/slider/';

        if (isset($request['DELETE_ALL'])) {
            if (isset($request->checkId)) {
                $list_id = $request->input('checkId');
                $count_max = sizeof($list_id);
                $count = 0;
                foreach ($list_id as $id) {
                    $slider = Slider::find($id);
                    if ($slider == null) {
                        return redirect()->route('slider.trash')->with('message', ['type' => 'danger', 'msg' => "Có mẫu tin không tồn tại!&&Đã xóa $count/$count_max !"]);
                    }
                    if ($slider->delete()) {
                        if (File::exists(public_path($path . $slider->image))) {
                            File::delete(public_path($path . $slider->image));
                        }
                        $count++;
                    }
                }
                return redirect()->route('slider.trash')->with('message', ['type' => 'success', 'msg' => "Xóa vĩnh viễn thành công $count/$count_max !"]);
            } else {
                return redirect()->route('slider.trash')->with('message', ['type' => 'danger', 'msg' => 'Chưa chọn mẫu tin!']);
            }
        }
        if (isset($request['RESTORE_ALL'])) {
            if (isset($request->checkId)) {
                $list_id = $request->input('checkId');
                $count_max = sizeof($list_id);
                $count = 0;
                foreach ($list_id as $id) {
                    $slider = Slider::find($id);
                    if ($slider == null) {
                        return redirect()->route('slider.trash')->with('message', ['type' => 'danger', 'msg' => "Có mẫu tin không tồn tại!&&Đã phục hồi $count/$count_max !"]);
                    }

                    $slider->status = 2;
                    $slider->updated_at = date('Y-m-d H:i:s');
                    $slider->updated_by = Auth::guard('admin')->user()->id;
                    $slider->save();
                    $count++;
                }
                return redirect()->route('slider.index')->with('message', ['type' => 'success', 'msg' => "Phục hồi thành công $count/$count_max !"]);
            } else {
                return redirect()->route('slider.trash')->with('message', ['type' => 'danger', 'msg' => 'Chưa chọn mẫu tin!']);
            }
        }
    }

    public function delete($id)
    {
        $slider = Slider::find($id);
        if ($slider == null) {
            return redirect()->route('slider.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }
        $slider->status = 0;
        $slider->updated_at = date('Y-m-d H:i:s');
        $slider->updated_by = Auth::guard('admin')->user()->id;
        $slider->save();
        return redirect()->route('slider.index')->with('message', ['type' => 'success', 'msg' => 'Xóa thành công!&& vào thùng rác để xem!!!']);
    }

    public function delete_multi(Request $request)
    {
        if (isset($request->checkId)) {
            $list_id = $request->input('checkId');
            $count_max = sizeof($list_id);
            $count = 0;
            foreach ($list_id as $id) {

                $slider = Slider::find($id);
                if ($slider == null) {
                    return redirect()->route('slider.index')->with('message', ['type' => 'danger', 'msg' => "Có mẫu tin không tồn tại!Đã xóa $count/$count_max ! "]);
                }
                $slider->status = 0;
                $slider->updated_at = date('Y-m-d H:i:s');
                $slider->updated_by = Auth::guard('admin')->user()->id;
                $slider->save();
                $count++;
            }
            return redirect()->route('slider.index')->with('message', ['type' => 'success', 'msg' => "Xóa thành công $count/$count_max !&& Vào thùng rác để xem!!!"]);
        } else {
            return redirect()->route('slider.index')->with('message', ['type' => 'danger', 'msg' => 'Chưa chọn mẫu tin!']);
        }
    }

    public function status($id)
    {

        $slider = Slider::find($id);
        if ($slider == null) {
            return redirect()->route('slider.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }

        $slider->status = ($slider->status == 1) ? 2 : 1;
        $slider->updated_at = date('Y-m-d H:i:s');
        $slider->updated_by = Auth::guard('admin')->user()->id;
        $slider->save();
        return redirect()->route('slider.index')->with('message', ['type' => 'success', 'msg' => 'Thay đổi trạng thái thành công!']);
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function restore($id)
    {

        $slider = Slider::find($id);
        if ($slider == null) {
            return redirect()->route('slider.trash')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }

        $slider->status = 2;
        $slider->updated_at = date('Y-m-d H:i:s');
        $slider->updated_by = Auth::guard('admin')->user()->id;
        $slider->save();
        return redirect()->route('slider.index')->with('message', ['type' => 'success', 'msg' => 'Phục hồi thành công!']);
    }
}
