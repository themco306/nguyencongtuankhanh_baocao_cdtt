
<tr class="form-qty">
    <th class="align-middle" scope="row"><i
            id="" class="fa-solid fa-circle-xmark delete-cart-item"></i>
    </th>
    <td class="align-middle"><img class="img-fluid" src=""></td>
    <td class="align-middle"><a href="" class="fw-200">{{ $cart->product->name }}</a></td>
    <td class=" align-middle"><span style="color:#FFAD03 ;">{{ number_format($product_price) }} VNĐ</span></td>
    <td class=" align-middle">
        <div class="ms-4 buy-amount" >
            <input type="hidden" value="{{ $cart->product->qty }} " class="qty_max">
            <input type="hidden" value="{{ $cart->product_id }} " class="product_id">
            
            <button class="minus-btn" >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15" />
                </svg>
            </button>
            <input type="text" class="amount" name="amount"  value="{{ $cart->qty }}">
            <button class="plus-btn" >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </button>
        </div>
    </td>
    <td class="align-middle"><a class="btn_addcart" 
            value="">Thanh toán</a></td>
</tr>