<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Link;
use App\Models\Post;
use App\Models\Product;
use App\Models\Product_sale;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiteController extends Controller
{
    public function index($slug = null)
    {
        if ($slug == null) {
            return  $this->home();
        } else {
            $link = Link::where('slug', '=', $slug)->first();
            if ($link == null) {
                $product = Product::where([['status', '=', '1'], ['slug', '=', $slug]])->first();
                if ($product != null) {
                    return $this->product_detail($product);
                } else {
                    $post = Post::where([['status', '=', '1'], ['slug', '=', $slug], ['type', '=', 'post']])->first();
                    if ($post != null) {
                        return $this->post_detail($post);
                    } else {
                        return $this->error_404($slug);
                    }
                }
            } else {
                $type = $link->type;
                switch ($type) {
                    case 'category': {
                            return $this->product_category($slug);
                        }
                    case 'brand': {
                            return $this->product_brand($slug);
                        }
                    case 'topic': {
                            return $this->post_topic($slug);
                        }
                    case 'page': {
                            return $this->post_page($slug);
                        }
                }
            }
        }
    }
    protected function home()
    {
        $title = "Trang chủ";
        $list_category = Category::where([
            ['parent_id', '=', 0],
            ['status', '=', 1]
        ])->orderBy('sort_order', 'desc')->get();
        return view('frontend.home', compact('list_category', 'title'));
    }
    protected function product_category($slug)
    {
        $cat = Category::where([['status', '=', '1'], ['slug', '=', $slug]])->first();
        $list_category = Category::where('status', '1')->orderBy('created_at', 'desc')->get();
        $list_brand = Brand::where('status', '1')->orderBy('created_at', 'desc')->get();
        $min_price = 0;
        $max_price = 1000000;
        $list_product = Product::with(['sale' => function ($query) {
            $query->whereRaw('? between date_begin and date_end', [now()]);
        }])->where('status', '=', '1')
            ->whereIn('category_id', [$cat->id])
            ->where(function ($query) use ($min_price, $max_price) {
                $query->whereHas('sale', function ($query) use ($min_price, $max_price) {
                    $query->whereBetween('price_sale', [$min_price, $max_price]);
                })->orWhereBetween('price', [$min_price, $max_price]);
            })
            ->orderBy('created_at', 'desc')
            ->take(12)
            ->get();
        return view('frontend.product_category', compact('list_product', 'cat', 'list_category', 'list_brand', 'min_price', 'max_price'));
    }
    protected function product_brand($slug)
    {
        $brand = Brand::where([['status', '=', '1'], ['slug', '=', $slug]])->first();
        $list_category = Category::where('status', '1')->orderBy('created_at', 'desc')->get();
        $list_brand = Brand::where('status', '1')->orderBy('created_at', 'desc')->get();
        $list_product = Product::with(['sale' => function ($query) {
            $query->whereRaw('? between date_begin and date_end', [now()]);
        }])->where('status', '=', '1')->whereIn('brand_id', [$brand->id])->orderBy('created_at', 'desc')->take(24)->paginate(12);
        return view('frontend.product_brand', compact('list_product', 'brand', 'list_category', 'list_brand'));
    }
    protected function post_topic($slug)
    {
        return view('frontend.post_topic');
    }
    protected function post_page($slug)
    {
        return view('frontend.post_page');
    }
    protected function product_detail($product)
    {
        if ($product == null) {
            return view('frontend.error_404');
        }
        $same_products = Product::with(['sale' => function ($query) {
            $query->whereRaw('? between date_begin and date_end', [now()]);
        }])->where([
            ['status', '=', '1'],
            ['category_id', '=', $product->category_id],
            ['id', '!=', $product->id]
        ])->orderBy('created_at', 'desc')->take(4)->get();
        return view('frontend.product_detail', compact('product', 'same_products'));
    }
    protected function post_detail($post)
    {
        return view('frontend.post_detail');
    }
    protected function error_404($slug)
    {
        return view('errors.404', compact('slug'));
    }
}
