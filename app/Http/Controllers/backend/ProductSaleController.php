<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductSaleStoreRequest;
use App\Http\Requests\ProductSaleUpdateRequest;
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

class ProductSaleController extends Controller
{


    public function index_sale()
    {
        $product_sale = Product_sale::get();
        $title = 'sản phẩm giảm giá';
        // return dd($product_store);
        return view("backend.product.sale.index", compact('title', 'product_sale'));
    }
    public function get_product_info($id)
    {

        $product = Product::find($id);
        $product_store = $product->store()->orderBy('created_at', 'desc')->select('price')->first();
        return response()->json([
            'qty_base' => $product->qty,
            'price_base' => $product_store->price ?? "Chưa nhập hàng",
            'price_selling' => $product->price
        ]);
    }
    public function create_sale($product_id = null)
    {

        $products = Product::select('id', 'name')->get();
        $html_product_id = "";
        foreach ($products as $product) {
            $html_product_id .= "<option value='" . $product->id . "'" . (($product->id == old('product_id', $product_id)) ? 'selected' : ' ') . ">" . $product->name . "</option>";
        }
        $title = 'Thêm giảm giá';
        return view("backend.product.sale.create", compact('title', 'html_product_id'));
    }
    public function edit_sale($product_id)
    {
        // $product_sale = Product_sale::where('product_id', $product_id)->first();
        $product_sale = Product_sale::find($product_id);
        if (!$product_sale) {
            return redirect()->route('product.index_sale')->with('message', ['type' => 'danger', 'msg' => 'Giảm giá không tồn tại']);
        }
        $products = Product::has('sale')->select('id', 'name')->get();
        $html_product_id = "";
        foreach ($products as $product) {
            $html_product_id .= "<option value='" . $product->id . "'" . (($product->id == old('product_id', $product_id)) ? 'selected' : ' ') . ">" . $product->name . "</option>";
        }
        $title = 'Sửa giảm giá';
        return view("backend.product.sale.edit", compact('title', 'html_product_id', 'product_sale'));
    }
    public function edit_store_sale(ProductSaleUpdateRequest $request)
    {
        $product_store_exists = Product_store::where('product_id', $request->product_id)->exists();
        if (!$product_store_exists) {
            return redirect()->route('product.create_sale', ['product' => $request->product_id])->with('message', ['type' => 'danger', 'msg' => 'Sản phẩm chưa được nhập hàng']);
        }
        $product_sale = Product_sale::where('product_id', $request->product_id)->first();
        $product_sale->product_id = $request->product_id;
        $product_sale->qty = $request->qty;
        $product_sale->discount = $request->discount;
        $product_sale->date_begin = $request->date_begin;
        $product_sale->date_end = $request->date_end;
        $product_sale->save();
        return redirect()->route('product.edit_sale', ['product' => $product_sale->id])->with('message', ['type' => 'success', 'msg' => 'Sửa thành công']);
    }
    public function store_sale(ProductSaleStoreRequest $request)
    {
        $product_store_exists = Product_store::where('product_id', $request->product_id)->exists();
        if (!$product_store_exists) {
            return redirect()->route('product.create_sale', ['product' => $request->product_id])->with('message', ['type' => 'danger', 'msg' => 'Sản phẩm chưa được nhập hàng']);
        }
        $product_sale = Product_sale::where('product_id', $request->product_id)->first();
        if ($product_sale) {
            return redirect()->route('product.edit_sale', ['product' => $request->product_id])->with('message', ['type' => 'danger', 'msg' => 'Sản phẩm đã được sale hãy sửa lại thay vì tạo mới']);
        }
        $product_sale = new Product_sale();
        $product_sale->product_id = $request->product_id;
        $product_sale->qty = $request->qty;
        $product_sale->discount = $request->discount;
        $product_sale->created_by = Auth::guard('admin')->user()->id;
        $product_sale->date_begin = $request->date_begin;
        $product_sale->date_end = $request->date_end;
        $product_sale->save();
        return redirect()->route('product.create_sale', ['product' => $request->product_id])->with('message', ['type' => 'success', 'msg' => 'Thêm thành công']);
    }
}
