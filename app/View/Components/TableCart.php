<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TableCart extends Component
{
    /**
     * Create a new component instance.
     */
    public $cart = null;
    public function __construct($rowcart)
    {
        $this->cart = $rowcart;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $cart = $this->cart;
        $product = $cart->product;
        $product_price = $product->price; // Định nghĩa giá trị mặc định cho biến $product_price
        if ($product->sale->price_sale != null) {
            $now = now();
            if ($product->sale->date_begin < $now && $now < $product->sale->date_end) {
                $product_price = $product->sale->price_sale;
            }
        }
        return view('components.table-cart', compact('product_price', 'cart'));
    }
}
