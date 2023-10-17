<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Menu;

class Sub2MainMenu extends Component
{
    /**
     * Create a new component instance.
     */
    public $row_menu1;
    public function __construct($rowmenu1)
    {
        $this->row_menu1 = $rowmenu1;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $row_menu1 = $this->row_menu1;
        $args = [
            ['parent_id', '=', $row_menu1->id],
            ['status', '=', 1],
            ['position', '=', 'mainmenu']
        ];
        $list_menu2 = Menu::where($args)->orderBy('sort_order', 'asc')->get();
        $checksub = false;
        if (count($list_menu2) != 0)
            $checksub = true;

        return view('components.sub2-main-menu', compact('row_menu1', 'checksub', 'list_menu2'));
    }
}
