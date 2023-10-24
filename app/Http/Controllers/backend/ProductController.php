<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Product_images;
use App\Models\Product_sale;
use App\Models\Product_store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function update_qty($id, $qty)
    {
        $product = Product::find($id);
        $product->qty += $qty;
        $product->updated_at = date('Y-m-d H:i:s');
        $product->updated_by = Auth::guard('admin')->user()->id;
        $product->save();
    }
    public function index()
    {
        //$list=Product::all();//try van tat ca
        $product = Product::join('category', 'product.category_id', '=', 'category.id')
            ->join('brand', 'product.brand_id', '=', 'brand.id')
            ->where('product.status', '!=', '0')
            ->orderBy('product.created_at', 'desc')
            ->select("product.*", "category.name as category_name", "brand.name as brand_name")

            ->get();
        $title = 'Tất Cả Sản Phẩm';
        return view("backend.product.index", compact('product', 'title'));
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////
    // public function index_store($id = null)
    // {
    //     $products = Product::select('id', 'name', 'images')->findAll();
    //     if ($id) {
    //         $product_store = Product_store::orderBy('product_id', 'desc')->findBy($id);
    //     }
    //     $title = 'Danh sách nhập sản phẩm';
    //     return view("backend.product.store.index", compact('title', 'products', 'product_store'));
    // }
    public function create()
    {
        $title = 'Thêm Sản Phẩm';
        $list_brand = Brand::where('status', '!=', '0')
            ->get();
        $list_category = Category::where('status', '!=', '0')
            ->get();
        $html_category_id = "";
        $html_brand_id = "";

        foreach ($list_category as $category) {
            $html_category_id .= "<option value='" . $category->id . "'" . (($category->id == old('category_id')) ? ' selected ' : ' ') . ">" . $category->name . "</option>";
        }
        foreach ($list_brand as $brand) {
            $html_brand_id .= "<option value='" . $brand->id . "'" . (($brand->id == old('brand_id')) ? 'selected' : ' ') . ">" . $brand->name . "</option>";
        }

        return view("backend.product.create", compact('title', 'html_category_id', 'html_brand_id'));
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function show($id)
    {

        $product = Product::find($id);
        if ($product == null) {
            return redirect()->route('product.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại']);
        }
        $user_create = User::find($product->created_by);
        $user_update = User::find($product->updated_by);
        $product_images = Product_images::where('product_id', '=', $id)->get();
        $title = 'Chi Tiết Sản Phẩm';
        return view("backend.product.show", compact('title', 'product', 'product_images', 'user_create', 'user_update'));
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function edit($id)
    {
        $title = 'Cập Nhật Sản Phẩm';
        $product = Product::where('product.id', $id)
            ->first();
        if ($product == null) {
            return redirect()->route('product.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại ']);
        }
        $list_brand = Brand::where('status', '!=', '0')
            ->get();
        $list_category = Category::where('status', '!=', '0')
            ->get();
        $str_option_category = "";
        $str_option_brand = "";
        foreach ($list_category as $category) {
            $str_option_category .= "<option value='" . $category->id . "'" . (($category->id == old('category_id', $product->category_id)) ? 'selected' : ' ') . ">" . $category->name . "</option>";
        }

        foreach ($list_brand as $brand) {
            $str_option_brand .= "<option value='" . $brand->id . "'" . (($brand->id == old('brand_id', $product->brand_id)) ? 'selected' : ' ') . ">" . $brand->name . "</option>";
        }

        return view("backend.product.edit", compact('title', 'product', 'str_option_category', 'str_option_brand'));
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function trash()
    {
        //$list=Product::all();//try van tat ca
        $product = Product::join('category', 'product.category_id', '=', 'category.id')
            ->join('brand', 'product.brand_id', '=', 'brand.id')
            ->where('product.status', '=', '0')
            ->orderBy('product.updated_at', 'desc')
            ->select("product.*", "category.name as category_name", "brand.name as brand_name")
            ->get();
        $title = 'Thùng rác sản phẩm';
        return view("backend.product.trash", compact('product', 'title'));
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function status($id)
    {

        $product = Product::find($id);
        if ($product == null) {
            return redirect()->route('product.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }
        if ($product->brand->status != 1) {
            $brand_name = $product->brand->name;
            return redirect()->route('product.index')->with('message', ['type' => 'danger', 'msg' => "Bạn cần thay đổi trạng thái của thương hiệu $brand_name trước  "]);
        }
        if ($product->category->status != 1) {
            $category_name = $product->category->name;
            return redirect()->route('product.index')->with('message', ['type' => 'danger', 'msg' => "Bạn cần thay đổi trạng thái của danh mục $category_name trước  "]);
        }
        $product->status = ($product->status == 1) ? 2 : 1;
        $product->updated_at = date('Y-m-d H:i:s');
        $product->updated_by = Auth::guard('admin')->user()->id;
        $product->save();
        return redirect()->route('product.index')->with('message', ['type' => 'success', 'msg' => 'Thay đổi trạng thái thành công!']);
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function restore($id)
    {

        $product = Product::find($id);
        if ($product == null) {
            return redirect()->route('product.trash')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }
        if ($product->brand->status == 0) {
            $brand_name = $product->brand->name;
            return redirect()->route('product.trash')->with('message', ['type' => 'danger', 'msg' => "Thương hiệu $brand_name đang trong thùng rác  "]);
        }
        if ($product->category->status == 0) {
            $category_name = $product->category->name;
            return redirect()->route('product.trash')->with('message', ['type' => 'danger', 'msg' => "Danh mục $category_name đang trong thùng rác  "]);
        }
        $product->status = 2;
        $product->updated_at = date('Y-m-d H:i:s');
        $product->updated_by = Auth::guard('admin')->user()->id;
        $product->save();
        return redirect()->route('product.index')->with('message', ['type' => 'success', 'msg' => 'Phục hồi thành công!']);
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function destroy($id)
    {

        $product = Product::find($id);
        if ($product == null) {
            return redirect()->route('product.trash')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }
        if ($product->delete()) {
            $path = 'images/product/';

            $list_product_images = $product->images;
            foreach ($list_product_images as $product_images) {
                if (File::exists(public_path($path . $product_images->image))) {
                    File::delete(public_path($path . $product_images->image));
                }
            }
            $product->sale()->delete();
            $product->images()->delete();
            return redirect()->route('product.trash')->with('message', ['type' => 'success', 'msg' => 'Xóa vĩnh viễn thành công!']);
        }
        return redirect()->route('product.trash')->with('message', ['type' => 'danger', 'msg' => 'Xóa thất bại!']);
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function trash_multi(Request $request)
    {
        $path = 'images/product/';

        if (isset($request['DELETE_ALL'])) {
            if (isset($request->checkId)) {
                $list_id = $request->input('checkId');
                $count_max = sizeof($list_id);
                $count = 0;
                foreach ($list_id as $id) {
                    $product = Product::find($id);
                    if ($product == null) {
                        return redirect()->route('product.trash')->with('message', ['type' => 'danger', 'msg' => "Có mẫu tin không tồn tại!&&Đã xóa $count/$count_max !"]);
                    }
                    if ($product->delete()) {
                        $path = 'images/product/';
                        $list_product_images = $product->images;
                        foreach ($list_product_images as $product_images) {
                            if (File::exists(public_path($path . $product_images->image))) {
                                File::delete(public_path($path . $product_images->image));
                            }
                        }
                        $product->sale()->delete();
                        $product->images()->delete();
                        $count++;
                    }
                }
                return redirect()->route('product.trash')->with('message', ['type' => 'success', 'msg' => "Xóa vĩnh viễn thành công $count/$count_max !"]);
            } else {
                return redirect()->route('product.trash')->with('message', ['type' => 'danger', 'msg' => 'Chưa chọn mẫu tin!']);
            }
        }
        if (isset($request['RESTORE_ALL'])) {
            if (isset($request->checkId)) {
                $list_id = $request->input('checkId');
                $count_max = sizeof($list_id);
                $count = 0;
                foreach ($list_id as $id) {
                    $product = Product::find($id);
                    if ($product == null) {
                        return redirect()->route('product.trash')->with('message', ['type' => 'danger', 'msg' => "Có mẫu tin không tồn tại!&&Đã phục hồi $count/$count_max !"]);
                    }
                    if ($product->brand->status == 0) {
                        $brand_name = $product->brand->name;
                        return redirect()->route('product.trash')->with('message', ['type' => 'danger', 'msg' => "Thương hiệu $brand_name đang trong thùng rác &&Đã phục hồi $count/$count_max  "]);
                    }
                    if ($product->category->status == 0) {
                        $category_name = $product->category->name;
                        return redirect()->route('product.trash')->with('message', ['type' => 'danger', 'msg' => "Danh mục $category_name đang trong thùng rác &&Đã phục hồi $count/$count_max "]);
                    }
                    $product->status = 2;
                    $product->updated_at = date('Y-m-d H:i:s');
                    $product->updated_by = Auth::guard('admin')->user()->id;
                    $product->save();
                    $count++;
                }
                return redirect()->route('product.index')->with('message', ['type' => 'success', 'msg' => "Phục hồi thành công $count/$count_max !"]);
            } else {
                return redirect()->route('product.trash')->with('message', ['type' => 'danger', 'msg' => 'Chưa chọn mẫu tin!']);
            }
        }
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function delete($id)
    {
        $product = Product::find($id);
        if ($product == null) {
            return redirect()->route('product.index')->with('message', ['type' => 'danger', 'msg' => 'Mẫu tin không tồn tại!']);
        }
        $product->status = 0;
        $product->updated_at = date('Y-m-d H:i:s');
        $product->updated_by = Auth::guard('admin')->user()->id;
        $product->save();
        return redirect()->route('product.index')->with('message', ['type' => 'success', 'msg' => 'Xóa thành công!&& vào thùng rác để xem!!!']);
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function delete_multi(Request $request)
    {
        if (isset($request->checkId)) {
            $list_id = $request->input('checkId');
            $count_max = sizeof($list_id);
            $count = 0;
            foreach ($list_id as $id) {
                $product = Product::find($id);
                if ($product == null) {
                    return redirect()->route('product.index')->with('message', ['type' => 'danger', 'msg' => "Có mẫu tin không tồn tại!Đã xóa $count/$count_max ! "]);
                }
                $product->status = 0;
                $product->updated_at = date('Y-m-d H:i:s');
                $product->updated_by = Auth::guard('admin')->user()->id;
                $product->save();
                $count++;
            }
            return redirect()->route('product.index')->with('message', ['type' => 'success', 'msg' => "Xóa thành công $count/$count_max !&& Vào thùng rác để xem!!!"]);
        } else {
            return redirect()->route('product.index')->with('message', ['type' => 'danger', 'msg' => 'Chưa chọn mẫu tin!']);
        }
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function store(ProductStoreRequest $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->slug = Str::slug($request->name, '-');
        $product->detail = $request->detail;
        $product->metakey = $request->metakey;
        $product->metadesc = $request->metadesc;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->qty = 0;
        $product->price = $request->price;
        // $product->level = 1;
        $product->status = $request->status;
        $product->created_at = date('Y-m-d H:i:s');
        $product->created_by = Auth::guard('admin')->user()->id;
        //upload file
        if ($product->save()) {

            // if ($request->filled('discount')) {
            //     $product_sale = new Product_sale();
            //     $product_sale->discount = $request->discount;
            //     $product_sale->date_begin = $request->date_begin;
            //     $product_sale->date_end = $request->date_end;
            //     $product->sale()->save($product_sale);
            // }

            if ($request->hasFile('images')) {
                $path = 'images/product/';
                $count = 1;
                $files = $request->file('images');
                foreach ($files as $file) {
                    $extension = $file->getClientOriginalExtension();
                    $filename = $product->slug . '-' . $count . '.' . $extension;
                    $file->move($path, $filename);
                    $product_images = new Product_images();
                    $product_images->image = $filename;
                    $product->images()->save($product_images);
                    $count++;
                }
            }
            return redirect()->route('product.index')->with('message', ['type' => 'success', 'msg' => 'Thêm thành công!']);
        } else {
            return redirect()->route('product.create')->with('message', ['type' => 'danger', 'msg' => 'Thêm thất bại!!']);
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function update(ProductUpdateRequest $request, $id)
    {
        $request->validate([
            'name' => [
                Rule::unique('product', 'name')->ignore($id),
                Rule::unique('brand', 'name'),
                Rule::unique('category', 'name'),
                Rule::unique('topic', 'name'),
                Rule::unique('post', 'title'),
            ]
        ], [
            'name.unique' => 'Tên đã được sử dụng. Vui lòng chọn tên khác.'
        ]);

        $product = Product::find($id);
        $product->name = $request->name;
        $product->slug = Str::slug($request->name, '-');
        $product->detail = $request->detail;
        $product->metakey = $request->metakey;
        $product->metadesc = $request->metadesc;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->qty = $request->qty;
        $product->price = $request->price;
        // $product->level = 1;
        $product->status = $request->status;
        $product->updated_at = date('Y-m-d H:i:s');
        $product->updated_by = Auth::guard('admin')->user()->id;
        //upload file


        if ($product->save()) {
            if ($request->hasFile('images')) {
                $path = 'images/product/';
                $files = $request->file('images');

                $list_product_images =  $product->images;
                $count = 1;

                foreach ($list_product_images as $product_images) {

                    $product_images->delete();
                    if (File::exists(public_path($path . $product_images->image))) {
                        File::delete(public_path($path . $product_images->image));
                    }
                }
                foreach ($files as $file) {
                    $extension = $file->getClientOriginalExtension();
                    $filename = $product->slug . '-' . $count . '.' . $extension;
                    $file->move($path, $filename);
                    $product_images = new Product_images();
                    $product_images->image = $filename;
                    $product_images->product_id = $product->id;

                    $product->images()->save($product_images);
                    $count++;
                }
            }
            return redirect()->route('product.index')->with('message', ['type' => 'success', 'msg' => 'Cập nhật thành công!']);
        } else {

            return redirect()->route('product.edit')->with('message', ['type' => 'danger', 'msg' => 'Cập nhật thất bại!!']);
        }
    }
}
