<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Post;

class PostHome extends Component
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
        $list_post = Post::where([
            ['type', '=', 'post'],
            ['status', '=', '1']
        ])->orderBy('created_at', 'desc')->take(4)->get();
        return view('components.post-home', compact('list_post'));
    }
}
