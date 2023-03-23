<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Link;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Request;

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
                    default: {
                            return $this->error_404($slug);
                        }
                }
            }
        }
    }
    protected function home()
    {
        return view('frontend.home');
    }
    protected function product_category($slug)
    {
        return view('frontend.product_category');
    }
    protected function product_brand($slug)
    {
        return view('frontend.product_brand');
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
        return view('frontend.product_detail');
    }
    protected function post_detail($post)
    {
        return view('frontend.post_detail');
    }
    protected function error_404($slug)
    {
        return view('frontend.error_404');
    }
}
