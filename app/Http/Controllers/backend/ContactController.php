<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contact = Contact::where('status', '!=', '0')
            ->orderBy('created_at', 'desc')
            ->get();
        $title = 'Tất Cả Liên Hệ';
        return view("backend.contact.index", compact('contact', 'title'));
    }


    public function show($id)
    {
        $contact = Contact::find($id);
        if ($contact == null) {
            return redirect()->route('contact.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại']);
        }
        $title = 'Chi Tiết Liên Hệ';
        return view("backend.contact.show", compact('title', 'contact'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $contact = Contact::find($id);
        if ($contact == null) {
            return redirect()->route('contact.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại']);
        }
        $title = 'Trả lời liên hệ';

        return view("backend.contact.edit", compact('title', 'contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $contact = Contact::find($id);
        $contact->replaydetail = $request->replaydetail;
        $contact->updated_at = date('Y-m-d H:i:s');
        $contact->updated_by = Auth::guard('admin')->user()->id;
        $contact->status = 2;
        if ($contact->save()) {
            return redirect()->route('contact.index')->with('message', ['type' => 'success', 'msg' => 'Trả lời thành công!']);
        }
        return redirect()->route('contact.edit')->with('message', ['type' => 'danger', 'msg' => 'Trả lời thất bại!!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $contact = Contact::find($id);
        if ($contact == null) {
            return redirect()->route('contact.trash')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }
        if ($contact->delete()) {
            return redirect()->route('contact.trash')->with('message', ['type' => 'success', 'msg' => 'Xóa vĩnh viễn thành công!']);
        }
        return redirect()->route('contact.trash')->with('message', ['type' => 'danger', 'msg' => 'Xóa thất bại!']);
    }
    public function trash()
    {
        //$list=Product::all();//try van tat ca
        $contact = Contact::where('status', '=', 0)->Orderby('updated_at', 'asc')->get();
        $title = 'Thùng rác liên hệ';
        return view("backend.contact.trash", compact('contact', 'title'));
    }

    public function trash_multi(Request $request)
    {

        if (isset($request['DELETE_ALL'])) {
            if (isset($request->checkId)) {
                $list_id = $request->input('checkId');
                $count_max = sizeof($list_id);
                $count = 0;
                foreach ($list_id as $id) {
                    $contact = Contact::find($id);
                    if ($contact == null) {
                        return redirect()->route('contact.trash')->with('message', ['type' => 'danger', 'msg' => "Có mẫu tin không tồn tại!&&Đã xóa $count/$count_max !"]);
                    }
                    if ($contact->delete()) {

                        $count++;
                    }
                }
                return redirect()->route('contact.trash')->with('message', ['type' => 'success', 'msg' => "Xóa vĩnh viễn thành công $count/$count_max !"]);
            } else {
                return redirect()->route('contact.trash')->with('message', ['type' => 'danger', 'msg' => 'Chưa chọn mẫu tin!']);
            }
        }
        if (isset($request['RESTORE_ALL'])) {
            if (isset($request->checkId)) {
                $list_id = $request->input('checkId');
                $count_max = sizeof($list_id);
                $count = 0;
                foreach ($list_id as $id) {
                    $contact = Contact::find($id);
                    if ($contact == null) {
                        return redirect()->route('contact.trash')->with('message', ['type' => 'danger', 'msg' => "Có mẫu tin không tồn tại!&&Đã phục hồi $count/$count_max !"]);
                    }

                    $contact->status = 2;
                    $contact->updated_at = date('Y-m-d H:i:s');
                    $contact->updated_by = Auth::guard('admin')->user()->id;
                    $contact->save();
                    $count++;
                }
                return redirect()->route('contact.index')->with('message', ['type' => 'success', 'msg' => "Phục hồi thành công $count/$count_max !"]);
            } else {
                return redirect()->route('contact.trash')->with('message', ['type' => 'danger', 'msg' => 'Chưa chọn mẫu tin!']);
            }
        }
    }

    public function delete($id)
    {
        $contact = Contact::find($id);
        if ($contact == null) {
            return redirect()->route('contact.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }
        $contact->status = 0;
        $contact->updated_at = date('Y-m-d H:i:s');
        $contact->updated_by = Auth::guard('admin')->user()->id;
        $contact->save();
        return redirect()->route('contact.index')->with('message', ['type' => 'success', 'msg' => 'Xóa thành công!&& vào thùng rác để xem!!!']);
    }

    public function delete_multi(Request $request)
    {
        if (isset($request->checkId)) {
            $list_id = $request->input('checkId');
            $count_max = sizeof($list_id);
            $count = 0;
            foreach ($list_id as $id) {

                $contact = Contact::find($id);
                if ($contact == null) {
                    return redirect()->route('contact.index')->with('message', ['type' => 'danger', 'msg' => "Có mẫu tin không tồn tại!Đã xóa $count/$count_max ! "]);
                }
                $contact->status = 0;
                $contact->updated_at = date('Y-m-d H:i:s');
                $contact->updated_by = Auth::guard('admin')->user()->id;
                $contact->save();
                $count++;
            }
            return redirect()->route('contact.index')->with('message', ['type' => 'success', 'msg' => "Xóa thành công $count/$count_max !&& Vào thùng rác để xem!!!"]);
        } else {
            return redirect()->route('contact.index')->with('message', ['type' => 'danger', 'msg' => 'Chưa chọn mẫu tin!']);
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function restore($id)
    {

        $contact = Contact::find($id);
        if ($contact == null) {
            return redirect()->route('contact.trash')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }

        $contact->status = 2;
        $contact->updated_at = date('Y-m-d H:i:s');
        $contact->updated_by = Auth::guard('admin')->user()->id;
        $contact->save();
        return redirect()->route('contact.index')->with('message', ['type' => 'success', 'msg' => 'Phục hồi thành công!']);
    }
}
