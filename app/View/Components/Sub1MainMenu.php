<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Menu;

class Sub1MainMenu extends Component
{
    /**
     * Create a new component instance.
     */
    public $row_menu;
    public function __construct($rowmenu)
    {
        $this->row_menu = $rowmenu;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $row_menu = $this->row_menu;
        $args = [
            ['parent_id', '=', $row_menu->id],
            ['status', '=', 1],
            ['position', '=', 'mainmenu']
        ];
        $list_menu1 = Menu::where($args)->orderBy('sort_order', 'asc')->get();
        $checksub = false;
        if (count($list_menu1) != 0)
            $checksub = true;

        return view('components.sub1-main-menu', compact('list_menu1', 'row_menu', 'checksub'));
    }
}
