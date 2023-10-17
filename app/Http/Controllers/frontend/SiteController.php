<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Link;
use App\Models\Post;
use App\Models\Product;
use App\Models\Product_sale;
use App\Models\Category;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiteController extends Controller
{
    public $paginate = 2;
    public $min_price = 0;
    public $max_price = 1000000;
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
                    $post_single = Post::where([['status', '=', '1'], ['slug', '=', $slug], ['type', '=', 'post']])->first();
                    if ($post_single != null) {
                        return $this->post_detail($post_single);
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
        $new_product = Product::with(['sale' => function ($query) {
            $query->whereRaw('? between date_begin and date_end', [now()]);
        }])->where('status', '1')->Orderby('created_at', 'desc')->take(4)->get();
        return view('frontend.home', compact('list_category', 'title', 'new_product'));
    }

    public function all_product()
    {
        // $list_category = Category::where('status', '1')->orderBy('created_at', 'desc')->get();
        // $list_brand = Brand::where('status', '1')->orderBy('created_at', 'desc')->get();
        if (isset($_GET['ten'])) {
            $ten = $_GET['ten'];
            $ten = $ten == 'z-a' ? 'desc' : 'asc';
            $list_product = Product::with(['sale' => function ($query) {
                $query->whereRaw('? between date_begin and date_end', [now()]);
            }])->where('status', '1')->Orderby('name', $ten)->paginate($this->paginate);
        } elseif (isset($_GET['gia'])) {
            $gia = $_GET['gia'];
            $gia = $gia == 'giam' ? 'desc' : 'asc';
            $list_product = Product::with(['sale' => function ($query) {
                $query->whereRaw('? between date_begin and date_end', [now()]);
            }])->where('status', '1')->Orderby('price', $gia)->paginate($this->paginate);
        } else {
            $list_product = Product::with(['sale' => function ($query) {
                $query->whereRaw('? between date_begin and date_end', [now()]);
            }])->where('status', '1')->Orderby('created_at', 'desc')->paginate($this->paginate);
        }

        return view('frontend.all_product', compact('list_product'));
    }
    protected function product_category($slug)
    {
        $cat = Category::where([['status', '=', '1'], ['slug', '=', $slug]])->first();
        // $list_category = Category::where('status', '1')->orderBy('created_at', 'desc')->get();
        // $list_brand = Brand::where('status', '1')->orderBy('created_at', 'desc')->get();
        if (isset($_GET['ten'])) {
            $ten = $_GET['ten'];
            $ten = $ten == 'z-a' ? 'desc' : 'asc';
            $list_product = Product::with(['sale' => function ($query) {
                $query->whereRaw('? between date_begin and date_end', [now()]);
            }])->where('status', '1')->whereIn('category_id', [$cat->id])->Orderby('name', $ten)->paginate($this->paginate);
        } elseif (isset($_GET['gia'])) {
            $gia = $_GET['gia'];
            $gia = $gia == 'giam' ? 'desc' : 'asc';
            $list_product = Product::with(['sale' => function ($query) {
                $query->whereRaw('? between date_begin and date_end', [now()]);
            }])->where('status', '1')->whereIn('category_id', [$cat->id])->Orderby('price', $gia)->paginate($this->paginate);
        } else {
            $list_product = Product::with(['sale' => function ($query) {
                $query->whereRaw('? between date_begin and date_end', [now()]);
            }])->where('status', '=', '1')->whereIn('category_id', [$cat->id])->OrderBy('created_at', 'desc')->paginate($this->paginate);
        }
        return view('frontend.product_category', compact('list_product', 'cat'));
    }
    protected function product_brand($slug)
    {
        $brand = Brand::where([['status', '=', '1'], ['slug', '=', $slug]])->first();
        // $list_category = Category::where('status', '1')->orderBy('created_at', 'desc')->get();
        // $list_brand = Brand::where('status', '1')->orderBy('created_at', 'desc')->get();
        if (isset($_GET['ten'])) {
            $ten = $_GET['ten'];
            $ten = $ten == 'z-a' ? 'desc' : 'asc';
            $list_product = Product::with(['sale' => function ($query) {
                $query->whereRaw('? between date_begin and date_end', [now()]);
            }])->where('status', '1')->whereIn('brand_id', [$brand->id])->Orderby('name', $ten)->paginate($this->paginate);
        } elseif (isset($_GET['gia'])) {
            $gia = $_GET['gia'];
            $gia = $gia == 'giam' ? 'desc' : 'asc';
            $list_product = Product::with(['sale' => function ($query) {
                $query->whereRaw('? between date_begin and date_end', [now()]);
            }])->where('status', '1')->whereIn('brand_id', [$brand->id])->Orderby('price', $gia)->paginate($this->paginate);
        } else {
            $list_product = Product::with(['sale' => function ($query) {
                $query->whereRaw('? between date_begin and date_end', [now()]);
            }])->where('status', '=', '1')->whereIn('brand_id', [$brand->id])->OrderBy('created_at', 'desc')->paginate($this->paginate);
        }
        return view('frontend.product_brand', compact('list_product', 'brand'));
    }
    public function all_post()
    {
        $list_post = Post::where([
            ['type', '=', 'post'],
            ['status', '=', '1']
        ])->orderBy('created_at', 'desc')->paginate($this->paginate);
        return view('frontend.all_post', compact('list_post'));
    }
    protected function post_topic($slug)
    {

        $topic = Topic::where([['status', '1'], ['slug', $slug]])->first();
        $list_post = Post::where([
            ['type', '=', 'post'],
            ['status', '=', '1'],
            ['topic_id', '=', $topic->id]
        ])->orderBy('created_at', 'desc')->paginate($this->paginate);
        return view('frontend.post_topic', compact('list_post', 'topic'));
    }
    protected function post_detail($post_single)
    {
        $topic = $post_single->topic;
        $list_post = Post::where([['status', '1'], ['topic_id', $topic->id], ['id', '!=', $post_single->id]])->Orderby('created_at', 'desc')->take(4)->get();
        return view('frontend.post_detail', compact('list_post', 'post_single'));
    }
    protected function post_page($slug)
    {
        $page = Post::where([['slug', '=', $slug], ['status', '=', 1]])->first();
        return view('frontend.post_page', compact('page'));
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

    protected function error_404($slug)
    {
        return view('errors.404', compact('slug'));
    }
}
