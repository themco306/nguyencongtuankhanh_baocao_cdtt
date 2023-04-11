<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;

use App\Models\Contact;
use Illuminate\Http\Request;

use App\Http\Requests\ContactStoreRequest;
use App\Models\Config;

class SiteContactController extends Controller
{
    public function index()
    {
        $title = "Liên Hệ";
        $list_option = "";
        $list = ['Bạn cần được hỗ trợ?', 'Bạn có ý tưởng?', 'Bộ phận bán hàng'];
        foreach ($list as $l)
            $list_option .= "<option value='" . $l . "'>" . $l . "</option>";
        $config = Config::first();

        return view('frontend.contact', compact('title', 'list_option', 'list', 'config'));
    }
    public function store(ContactStoreRequest $request)
    {
        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->title = $request->title;
        $contact->detail = $request->detail;
        $contact->status = 1;
        $contact->created_at =  date('Y-m-d H:i:s');
        if ($contact->save())
            return redirect()->route('site.lienhe')->with('message', ['type' => 'success', 'msg' => 'Xin cám ơn bạn đã đóng góp ý kiến , chúng tôi sẽ phản hồi bạn nhanh nhất']);
        return redirect()->route('site.lienhe')->with('message', ['type' => 'danger', 'msg' => 'Có một số lỗi xảy ra xin bạn F5 lại trang']);
    }
}
