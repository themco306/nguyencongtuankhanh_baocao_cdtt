<?php

namespace App\View\Components;

use App\Models\Menu;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SiteFooterMenu extends Component
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
        $arg_mainmenu = [
            ['parent_id', '=', 0],
            ['status', '=', 1],
            ['position', '=', 'footermenu']
        ];
        $list_menu = Menu::where($arg_mainmenu)->orderBy('sort_order', 'asc')->get();
        return view('components.site-footer-menu', compact('list_menu'));
    }
}
