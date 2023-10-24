<?php

namespace App\View\Components;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SiteFilter extends Component
{
    /**
     * Create a new component instance.
     */
    public $slug = null;
    public function __construct($slugselect)
    {
        $this->slug = $slugselect;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $slugselect = $this->slug;
        $list_category = Category::where('status', '1')->orderBy('created_at', 'desc')->get();
        $list_brand = Brand::where('status', '1')->orderBy('created_at', 'desc')->get();
        $range_price = [];

        $products = Product::where('status', '1')->get();

        foreach ($products as $product) {
            if ($product->sale && $product->sale->date_begin <= \Carbon\Carbon::now() && $product->sale->date_end >= \Carbon\Carbon::now()) {
                $range_price[] = $product->price - ($product->sale->discount / 100 * $product->price);
            } else {
                $range_price[] = $product->price;
            }
        }

        $min_price = min($range_price);
        $max_price = max($range_price);

        return view('components.site-filter', compact('list_category', 'list_brand', 'slugselect', 'min_price', 'max_price'));
    }
}
