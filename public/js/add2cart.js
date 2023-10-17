function add2cart(id){
    let cart_qty=document.getElementById('amount').value;
  
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
        if(response.success){
            swal("Thành công!!", response.success, "success", { timer: 10000 });

        }
        else{
            swal("Thông báo!!", response.alert, { timer: 10000 });

        }


    }
   });


}