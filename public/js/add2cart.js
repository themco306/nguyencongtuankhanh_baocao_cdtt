function add2cart(id){
    let cart_qty;
    if (typeof amount === "undefined") {
         cart_qty=1;
    } else {
        cart_qty=amount;
    }
  
   let addcart_url=document.getElementById('addcart_url').value;
   $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
});
   $.ajax({
    type: "POST",
    url: addcart_url,
    data: {
        'product_id':id,
        'qty':cart_qty
    },
    success: function (response) {
        alert(response.status);
    }
   });


}