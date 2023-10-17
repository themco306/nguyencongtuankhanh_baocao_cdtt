<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Slider;

class SliderShow extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $list_slider = Slider::where([['status', '=', '1'], ['position', '=', 'slideshow']])->orderBy('sort_order', 'asc')->get();
        return view('components.slider-show', compact('list_slider'));
    }
}
