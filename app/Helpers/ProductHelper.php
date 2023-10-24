<?php

namespace App\Helpers;

class ProductHelper
{
    public static function calculatePrice($product)
    {
        $price = $product->price;
        $discountedPrice = $price;
        $discount = 0;
        $inSale = false;

        if ($product->sale && $product->sale->date_begin <= \Carbon\Carbon::now() && $product->sale->date_end >= \Carbon\Carbon::now()) {
            $discount = $product->sale->discount;
            $discountedPrice = $price - ($discount / 100 * $price);
            $inSale = true;
        }

        // Tạo một đối tượng và gán giá trị vào các thuộc tính
        $result = new \stdClass();
        $result->price = $price;
        $result->discountedPrice = $discountedPrice;
        $result->discount = $discount;
        $result->inSale = $inSale;

        return $result;
    }
}
