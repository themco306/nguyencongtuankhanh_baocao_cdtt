<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $post = Post::join('topic', 'post.topic_id', '=', 'topic.id')
            ->where('post.status', '!=', '0')
            ->orderBy('post.created_at', 'desc')
            ->select("post.*", "topic.name as topic_name")
            ->get();
        $title = 'Tất Cả  Bài Viết';
        return view("backend.post.index", compact('post', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Thêm Bài Viết';
        $list = Topic::where('status', '!=', '0')
            ->get();
        $html_topic_id = "";
        foreach ($list as $item) {
            $html_topic_id .= "<option value='" . $item->id . "'" . (($item->id == old('topic_id')) ? ' selected ' : ' ') . ">" . $item->name . "</option>";
        }
        return view("backend.post.create", compact('title', 'html_topic_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostStoreRequest $request)
    {
        $post = new Post();
        $post->title = $request->title;
        $post->slug = Str::slug($request->title, '-');
        $post->metakey = $request->metakey;
        $post->metadesc = $request->metadesc;
        $post->detail = $request->detail;
        $post->status = $request->status;
        $post->topic_id = $request->topic_id;
        $post->type = 'post';
        $post->created_at = date('Y-m-d H:i:s');
        $post->created_by = Auth::guard('admin')->user()->id;
        //upload file

        if ($request->hasFile('image')) {
            $path = 'images/post/';
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = $post->slug . '.' . $extension;
            $file->move($path, $filename);
            $post->image = $filename;
        }
        if ($post->save()) {
            return redirect()->route('post.index')->with('message', ['type' => 'success', 'msg' => 'Thêm thành công!']);
        }
        return redirect()->route('post.create')->with('message', ['type' => 'danger', 'msg' => 'Thêm thất bại!!']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = Post::find($id);
        if ($post == null) {
            return redirect()->route('post.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại']);
        }
        $title = 'Chi Tiết Bài Viết';
        return view("backend.post.show", compact('title', 'post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $title = 'Sửa Bài Viết';
        $post = Post::where([['status', '!=', 0], ['id', '=', $id]])->first();
        if ($post == null) {
            return redirect()->route('post.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại']);
        }
        $list_topic = Topic::where('status', '!=', 0)->get();
        $html_topic_id = "";
        foreach ($list_topic as $topic) {
            $html_topic_id .= "<option value='" . $topic->id . "'" . (($topic->id == old('topic_id', $post->topic_id)) ? ' selected ' : ' ') . ">" . $topic->name . "</option>";
        }
        return view("backend.post.edit", compact('title', 'html_topic_id', 'post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostUpdateRequest $request, $id)
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
        $post = Post::find($id);
        $post->title = $request->title;
        $post->slug = Str::slug($request->title, '-');
        $post->metakey = $request->metakey;
        $post->metadesc = $request->metadesc;
        $post->detail = $request->detail;
        $post->status = $request->status;

        $post->updated_at = date('Y-m-d H:i:s');
        $post->updated_by = Auth::guard('admin')->user()->id;
        //upload file

        if ($request->hasFile('image')) {
            $path = 'images/post/';
            if (File::exists(public_path($path . $post->image))) {
                File::delete(public_path($path . $post->image));
            }
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = $post->slug . '.' . $extension;
            $file->move($path, $filename);
            $post->image = $filename;
        }
        if ($post->save()) {

            return redirect()->route('post.index')->with('message', ['type' => 'success', 'msg' => 'Cập nhật thành công!']);
        }
        return redirect()->route('post.edit')->with('message', ['type' => 'danger', 'msg' => 'Cập nhật thất bại!!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if ($post == null) {
            return redirect()->route('post.trash')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }
        if ($post->delete()) {
            $path = 'images/post/';
            if (File::exists(public_path($path . $post->image))) {
                File::delete(public_path($path . $post->image));
            }

            return redirect()->route('post.trash')->with('message', ['type' => 'success', 'msg' => 'Xóa vĩnh viễn thành công!']);
        }
        return redirect()->route('post.trash')->with('message', ['type' => 'danger', 'msg' => 'Xóa thất bại!']);
    }

    public function trash()
    {
        //$list=Product::all();//try van tat ca
        $post = Post::where([['status', '=', '0'], ['type', '=', 'post']])->Orderby('updated_at', 'asc')->get();
        $title = 'Thùng rác bài viết';
        return view("backend.post.trash", compact('post', 'title'));
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
                    $post = Post::find($id);
                    if ($post == null) {
                        return redirect()->route('post.trash')->with('message', ['type' => 'danger', 'msg' => "Có mẫu tin không tồn tại!&&Đã xóa $count/$count_max !"]);
                    }

                    if ($post->delete()) {
                        if (File::exists(public_path($path . $post->image))) {
                            File::delete(public_path($path . $post->image));
                        }

                        $count++;
                    }
                }
                return redirect()->route('post.trash')->with('message', ['type' => 'success', 'msg' => "Xóa vĩnh viễn thành công $count/$count_max !"]);
            } else {
                return redirect()->route('post.trash')->with('message', ['type' => 'danger', 'msg' => 'Chưa chọn mẫu tin!']);
            }
        }
        if (isset($request['RESTORE_ALL'])) {
            if (isset($request->checkId)) {
                $list_id = $request->input('checkId');
                $count_max = sizeof($list_id);
                $count = 0;
                foreach ($list_id as $id) {
                    $post = Post::find($id);
                    if ($post == null) {
                        return redirect()->route('post.trash')->with('message', ['type' => 'danger', 'msg' => "Có mẫu tin không tồn tại!&&Đã phục hồi $count/$count_max !"]);
                    }
                    if ($post->topic && $post->topic->status == 0) {
                        return redirect()->route('post.trash')->with('message', ['type' => 'danger', 'msg' => "Có chủ đề của bài viết đang trong thùng rác && Đã phục hồi $count/$count_max ! "]);
                    }
                    $post->status = 2;
                    $post->updated_at = date('Y-m-d H:i:s');
                    $post->updated_by = Auth::guard('admin')->user()->id;
                    $post->save();
                    $count++;
                }
                return redirect()->route('post.index')->with('message', ['type' => 'success', 'msg' => "Phục hồi thành công $count/$count_max !"]);
            } else {
                return redirect()->route('post.trash')->with('message', ['type' => 'danger', 'msg' => 'Chưa chọn mẫu tin!']);
            }
        }
    }
    public function delete($id)
    {
        $post = Post::find($id);
        if ($post == null) {
            return redirect()->route('post.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }
        $post->status = 0;
        $post->updated_at = date('Y-m-d H:i:s');
        $post->updated_by = Auth::guard('admin')->user()->id;
        $post->save();
        return redirect()->route('post.index')->with('message', ['type' => 'success', 'msg' => 'Xóa thành công!&& vào thùng rác để xem!!!']);
    }

    public function delete_multi(Request $request)
    {
        if (isset($request->checkId)) {
            $list_id = $request->input('checkId');
            $count_max = sizeof($list_id);
            $count = 0;
            foreach ($list_id as $id) {
                $post = Post::find($id);
                if ($post == null) {
                    return redirect()->route('post.index')->with('message', ['type' => 'danger', 'msg' => "Có mẫu tin không tồn tại!Đã xóa $count/$count_max ! "]);
                }
                $post->status = 0;
                $post->updated_at = date('Y-m-d H:i:s');
                $post->updated_by = Auth::guard('admin')->user()->id;
                $post->save();
                $count++;
            }
            return redirect()->route('post.index')->with('message', ['type' => 'success', 'msg' => "Xóa thành công $count/$count_max !&& Vào thùng rác để xem!!!"]);
        } else {
            return redirect()->route('post.index')->with('message', ['type' => 'danger', 'msg' => 'Chưa chọn mẫu tin!']);
        }
    }

    public function status($id)
    {

        $post = Post::find($id);
        if ($post == null) {
            return redirect()->route('post.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }
        if ($post->topic && $post->topic->status != 1) {
            return redirect()->route('post.index')->with('message', ['type' => 'danger', 'msg' => 'Bạn cần thay đổi trạng thái chủ đề bài viết trước']);
        }
        $post->status = ($post->status == 1) ? 2 : 1;
        $post->updated_at = date('Y-m-d H:i:s');
        $post->updated_by = Auth::guard('admin')->user()->id;
        $post->save();
        return redirect()->route('post.index')->with('message', ['type' => 'success', 'msg' => 'Thay đổi trạng thái thành công!']);
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function restore($id)
    {

        $post = Post::find($id);
        if ($post == null) {
            return redirect()->route('post.trash')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }
        if ($post->topic && $post->topic->status == 0) {
            return redirect()->route('post.trash')->with('message', ['type' => 'danger', 'msg' => 'Chủ đề của bài viết này đang trong thùng rác && bạn cần thay đổi nó trước']);
        }
        $post->status = 2;
        $post->updated_at = date('Y-m-d H:i:s');
        $post->updated_by = Auth::guard('admin')->user()->id;
        $post->save();
        return redirect()->route('post.index')->with('message', ['type' => 'success', 'msg' => 'Phục hồi thành công!']);
    }
}
