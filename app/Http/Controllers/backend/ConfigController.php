<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConfigStoreRequest;
use App\Models\Config;

class ConfigController extends Controller
{
    public function index()
    {
        $title = "Thông tin trang web";
        $config = Config::first();
        return view('backend.config.index', compact('title', 'config'));
    }
    public function addoredit(ConfigStoreRequest $request)
    {
        if ($request->id != 0) {
            $config = Config::findOrFail($request->id);
            $config->name = $request->name;
            $config->metakey = $request->metakey;
            $config->metadesc = $request->metadesc;
            $config->slogan = $request->slogan;
            $config->phone = $request->phone;
            $config->email = $request->email;
            $config->facebook = $request->facebook;
            if ($config->save()) {
                return redirect()->route('config.index')->with('message', ['type' => 'success', 'msg' => 'Sửa thành công!']);
            }
            return redirect()->route('config.index')->with('message', ['type' => 'danger', 'msg' => 'Sửa thất bại!!']);
        } else {
            $config = new Config();
            $config->name = $request->name;
            $config->metakey = $request->metakey;
            $config->metadesc = $request->metadesc;
            $config->slogan = $request->slogan;
            $config->phone = $request->phone;
            $config->email = $request->email;
            $config->facebook = $request->facebook;
            if ($config->save()) {
                return redirect()->route('config.index')->with('message', ['type' => 'success', 'msg' => 'Thêm thành công!']);
            }
            return redirect()->route('config.index')->with('message', ['type' => 'danger', 'msg' => 'Thêm thất bại!!']);
        }
    }
}
