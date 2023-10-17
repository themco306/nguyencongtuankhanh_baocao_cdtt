<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Menu;

class MainMenu extends Component
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

        $arg_mainmenu1 = [
            ['parent_id', '=', 0],
            ['status', '=', 1],
            ['position', '=', 'mainmenu']
        ];
        $list_menu = Menu::where($arg_mainmenu1)->orderBy('sort_order', 'asc')->get();
        return view('components.main-menu', compact('list_menu'));
    }
}
