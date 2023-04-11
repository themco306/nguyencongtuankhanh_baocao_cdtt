<?php

namespace App\View\Components;

use App\Models\Category;
use App\Models\Brand;
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
        return view('components.site-filter', compact('list_category', 'list_brand', 'slugselect'));
    }
}
