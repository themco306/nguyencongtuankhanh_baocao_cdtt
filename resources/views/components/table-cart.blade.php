
<tr>
    <th class="align-middle" scope="row"><i onclick="del_wishlist(this.id)"
            id="" class="fa-solid fa-circle-xmark "></i>
    </th>
    <td class="align-middle"><img class="img-fluid" src=""></td>
    <td class="align-middle"><a href="" class="fw-200">{{ $cart->product->name }}</a></td>
    <td class=" align-middle"><span style="color:#FFAD03 ;">{{ number_format($product_price) }} VNĐ</span></td>
    <td class=" align-middle"><span >{{ $cart->qty }}</span></td>
    <td class="align-middle"><a class="btn_addcart" 
            value="">Thanh toán</a></td>
</tr>