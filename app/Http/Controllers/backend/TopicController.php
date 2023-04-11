<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\TopicStoreRequest;
use App\Http\Requests\TopicUpdateRequest;
use App\Models\Link;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $topic = Topic::where('status', '!=', '0')
            ->orderBy('created_at', 'desc')
            ->get();
        $title = 'Tất Cả Chủ Đề Bài Viết';
        return view("backend.topic.index", compact('topic', 'title'));
    }
    public function create()
    {
        $title = 'Thêm Chủ Đề Bài Viết';
        $topic = Topic::where('status', '!=', '0')
            ->get();
        $html_sort_order = "";
        $html_parent_id = "";

        foreach ($topic as $item) {
            $html_sort_order .= "<option value='" . ($item->sort_order + 1) . "'" . (($item->sort_order + 1 == old('sort_order')) ? ' selected ' : ' ') . " >Sau: " . $item->name . "</option>";

            $html_parent_id .= "<option value='" . $item->id . "'" . (($item->id == old('parent_id')) ? ' selected ' : ' ') . ">" . $item->name . "</option>";
        }
        return view("backend.topic.create", compact('title', 'html_sort_order', 'html_parent_id'));
    }
    public function status($id)
    {

        $topic = Topic::find($id);
        if ($topic == null) {
            return redirect()->route('topic.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }

        $topic->status = ($topic->status == 1) ? 2 : 1;
        $topic->updated_at = date('Y-m-d H:i:s');
        $topic->updated_by = Auth::guard('admin')->user()->id;
        if ($topic->save()) {
            if ($topic->status == 2) {
                $topic->post()->update([
                    'status' => 2,
                    'updated_by' => Auth::guard('admin')->user()->id
                ]);
                $topic->menu()->update([
                    'status' => 2,
                    'updated_by' => Auth::guard('admin')->user()->id
                ]);
            }
            return redirect()->route('topic.index')->with('message', ['type' => 'success', 'msg' => 'Thay đổi trạng thái thành công!']);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(TopicStoreRequest $request)
    {
        $topic = new Topic();
        $topic->name = $request->name;
        $topic->slug = Str::slug($request->name, '-');
        $topic->metakey = $request->metakey;
        $topic->metadesc = $request->metadesc;
        $topic->sort_order = $request->sort_order;
        $topic->parent_id = $request->parent_id;
        // $topic->level = 1;
        $topic->status = $request->status;
        $topic->created_at = date('Y-m-d H:i:s');
        $topic->created_by = Auth::guard('admin')->user()->id;
        //upload file

        if ($topic->save()) {
            $link = new Link();
            $link->slug = $topic->slug;
            $link->table_id = $topic->id;
            $link->type = 'topic';
            $link->save();
            return redirect()->route('topic.index')->with('message', ['type' => 'success', 'msg' => 'Thêm thành công!']);
        }

        return redirect()->route('topic.create')->with('message', ['type' => 'danger', 'msg' => 'Thêm thất bại!!']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $topic = Topic::find($id);
        if ($topic == null) {
            return redirect()->route('topic.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại']);
        }
        $title = 'Chi Tiết Danh Mục';
        return view("backend.topic.show", compact('title', 'topic'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $title = 'Sửa Chủ Đề Bài Viết';
        $topic = Topic::where([['status', '!=', '0'], ['id', '=', $id]])
            ->first();
        if ($topic == null) {
            return redirect()->route('topic.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại']);
        }
        $list = Topic::where([['status', '!=', '0'], ['id', '!=', $id]])
            ->get();

        $html_sort_order = "";
        $html_parent_id = "";
        foreach ($list as $item) {

            $html_sort_order .= "<option value='" . ($item->sort_order + 1) . "'" . (($item->sort_order + 1 == old('sort_order', $topic->sort_order)) ? ' selected ' : ' ') . ">Sau: " . $item->name . "</option>";
            $html_parent_id .= "<option value='" . $item->id . "'" . (($item->id == old('parent_id')) ? ' selected ' : ' ') . ">" . $item->name . "</option>";
        }
        return view("backend.topic.edit", compact('title', 'html_sort_order', 'topic', 'html_parent_id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TopicUpdateRequest $request, $id)
    {
        $request->validate([
            'name' => [
                Rule::unique('topic', 'name')->ignore($id),
                Rule::unique('product', 'name'),
                Rule::unique('brand', 'name'),
                Rule::unique('category', 'name'),
                Rule::unique('post', 'title'),
            ]
        ], [
            'name.unique' => 'Tên đã được sử dụng. Vui lòng chọn tên khác.'
        ]);
        $topic = Topic::find($id);
        $topic->name = $request->name;
        $topic->slug = Str::slug($request->name, '-');
        $topic->metakey = $request->metakey;
        $topic->metadesc = $request->metadesc;
        $topic->sort_order = $request->sort_order;
        $topic->parent_id = $request->parent_id;
        // $topic->level = 1;
        $topic->status = $request->status;
        $topic->updated_at = date('Y-m-d H:i:s');
        $topic->updated_by = Auth::guard('admin')->user()->id;
        //upload file

        if ($topic->save()) {
            if ($topic->status == 2) {
                $topic->post()->update([
                    'status' => 2,
                    'updated_by' => Auth::guard('admin')->user()->id
                ]);
                $topic->menu()->update([
                    'status' => 2,
                    'updated_by' => Auth::guard('admin')->user()->id
                ]);
            }
            $topic->link()->update([
                'slug' => $topic->slug,
            ]);
            $topic->menu()->update([
                'name' => $topic->name,

                'link' => $topic->slug,
                'updated_by' => Auth::guard('admin')->user()->id
            ]);
            return redirect()->route('topic.index')->with('message', ['type' => 'success', 'msg' => 'Cập nhật thành công!']);
        }
        return redirect()->route('topic.edit')->with('message', ['type' => 'danger', 'msg' => 'Cập nhật thất bại!!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $topic = Topic::find($id);
        if ($topic == null) {
            return redirect()->route('topic.trash')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }
        if ($topic->delete()) {
            $topic->post()->update([
                'status' => 0,
                'updated_by' => Auth::guard('admin')->user()->id
            ]);
            $topic->menu()->delete();
            $topic->link()->delete();
            return redirect()->route('topic.trash')->with('message', ['type' => 'success', 'msg' => 'Xóa vĩnh viễn thành công!']);
        }
        return redirect()->route('topic.trash')->with('message', ['type' => 'danger', 'msg' => 'Xóa thất bại!']);
    }
    public function delete($id)
    {
        $topic = Topic::find($id);
        if ($topic == null) {
            return redirect()->route('topic.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }
        $topic->status = 0;
        $topic->updated_at = date('Y-m-d H:i:s');
        $topic->updated_by = Auth::guard('admin')->user()->id;
        if ($topic->save()) {
            if ($topic->status == 0) {
                $topic->post()->update([
                    'status' => 0,
                    'updated_by' => Auth::guard('admin')->user()->id
                ]);
                $topic->menu()->update([
                    'status' => 0,
                    'updated_by' => Auth::guard('admin')->user()->id
                ]);
            }
            return redirect()->route('topic.index')->with('message', ['type' => 'success', 'msg' => 'Xóa thành công!&& vào thùng rác để xem!!!']);
        }
    }

    public function delete_multi(Request $request)
    {
        if (isset($request->checkId)) {

            $list_id = $request->input('checkId');
            $count_max = sizeof($list_id);
            $count = 0;
            foreach ($list_id as $id) {
                $topic = Topic::find($id);
                if ($topic == null) {
                    return redirect()->route('topic.index')->with('message', ['type' => 'danger', 'msg' => "Có mẫu tin không tồn tại!Đã xóa $count/$count_max ! "]);
                }
                $topic->status = 0;
                $topic->updated_at = date('Y-m-d H:i:s');
                $topic->updated_by = Auth::guard('admin')->user()->id;
                if ($topic->save()) {
                    if ($topic->status == 0) {
                        $topic->post()->update([
                            'status' => 0,
                            'updated_by' => Auth::guard('admin')->user()->id
                        ]);
                        $topic->menu()->update([
                            'status' => 0,
                            'updated_by' => Auth::guard('admin')->user()->id
                        ]);
                    }
                }
                $count++;
            }
            return redirect()->route('topic.index')->with('message', ['type' => 'success', 'msg' => "Xóa thành công $count/$count_max !&& Vào thùng rác để xem!!!"]);
        } else {
            return redirect()->route('topic.index')->with('message', ['type' => 'danger', 'msg' => 'Chưa chọn mẫu tin!']);
        }
    }
    public function trash()
    {
        //$list=Product::all();//try van tat ca
        $topic = Topic::where('status', '=', 0)->Orderby('updated_at', 'asc')->get();
        $title = 'Thùng rác danh mục';
        return view("backend.topic.trash", compact('topic', 'title'));
    }
    public function trash_multi(Request $request)
    {

        if (isset($request['DELETE_ALL'])) {
            if (isset($request->checkId)) {
                $list_id = $request->input('checkId');
                $count_max = sizeof($list_id);
                $count = 0;
                foreach ($list_id as $id) {
                    $topic = Topic::find($id);
                    if ($topic == null) {
                        return redirect()->route('topic.trash')->with('message', ['type' => 'danger', 'msg' => "Có mẫu tin không tồn tại!&&Đã xóa $count/$count_max !"]);
                    }
                    if ($topic->delete()) {
                        $topic->post()->update([
                            'status' => 0,
                            'updated_by' => Auth::guard('admin')->user()->id
                        ]);
                        $topic->menu()->delete();
                        $topic->link()->delete();
                        $count++;
                    }
                }
                return redirect()->route('topic.trash')->with('message', ['type' => 'success', 'msg' => "Xóa vĩnh viễn thành công $count/$count_max !"]);
            } else {
                return redirect()->route('topic.trash')->with('message', ['type' => 'danger', 'msg' => 'Chưa chọn mẫu tin!']);
            }
        }
        if (isset($request['RESTORE_ALL'])) {
            if (isset($request->checkId)) {
                $list_id = $request->input('checkId');
                $count_max = sizeof($list_id);
                $count = 0;
                foreach ($list_id as $id) {

                    $topic = Topic::find($id);
                    if ($topic == null) {
                        return redirect()->route('topic.trash')->with('message', ['type' => 'danger', 'msg' => "Có mẫu tin không tồn tại!&&Đã phục hồi $count/$count_max !"]);
                    }

                    $topic->status = 2;
                    $topic->updated_at = date('Y-m-d H:i:s');
                    $topic->updated_by = Auth::guard('admin')->user()->id;
                    $topic->save();
                    $count++;
                }
                return redirect()->route('topic.index')->with('message', ['type' => 'success', 'msg' => "Phục hồi thành công $count/$count_max !"]);
            }
        } else {
            return redirect()->route('brand.trash')->with('message', ['type' => 'danger', 'msg' => 'Chưa chọn mẫu tin!']);
        }
    }

    public function restore($id)
    {

        $topic = Topic::find($id);
        if ($topic == null) {
            return redirect()->route('topic.trash')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }

        $topic->status = 2;
        $topic->updated_at = date('Y-m-d H:i:s');
        $topic->updated_by = Auth::guard('admin')->user()->id;
        $topic->save();
        return redirect()->route('topic.index')->with('message', ['type' => 'success', 'msg' => 'Phục hồi thành công!']);
    }
}
