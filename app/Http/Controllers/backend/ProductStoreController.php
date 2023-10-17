<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductStoreStoreRequest;
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

class ProductStoreController extends Controller
{


    public function index_store()
    {
        $product_store = Product_store::get();
        $title = 'sản phẩm đã nhập';
        // return dd($product_store);
        return view("backend.product.store.index", compact('title', 'product_store'));
    }
    public function get_product_qty($id)
    {
        $product = Product::find($id);
        return response()->json(['qty' => $product->qty]);
    }
    public function create_store($product_id = null)
    {
        $products = Product::select('id', 'name')->get();
        $html_product_id = "";
        foreach ($products as $product) {
            $html_product_id .= "<option value='" . $product->id . "'" . (($product->id == old('product_id', $product_id)) ? 'selected' : ' ') . ">" . $product->name . "</option>";
        }
        $title = 'Nhập sản phẩm';
        return view("backend.product.store.create", compact('title', 'html_product_id'));
    }
    public function store_store(ProductStoreStoreRequest $request)
    {
        $product_store = new Product_store;
        $product_store->product_id = $request->product_id;
        $product_store->qty = $request->qty;
        $product_store->price = $request->price;
        $product_store->created_by = Auth::guard('admin')->user()->id;
        $product_store->created_at = date('Y-m-d H:i:s');
        $productController = new ProductController;
        $productController->update_qty($request->product_id, $request->qty);
        $product_store->save();
        return redirect()->route('product.create_store', ['product' => $request->product_id])->with('message', ['type' => 'success', 'msg' => 'Thêm thành công']);
    }
}
