
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
           

// Tạo thông báo
Toastify({
    text: response.success,
    backgroundColor:'#00BF2A',
    duration: 3000,
    offset: {
        y: 50, // Không cần khoảng cách từ cạnh trên của màn hình
    },
}).showToast();

        }
        else{
            Toastify({
                text: response.alert,
                backgroundColor:'#E27438',
                offset: {
                    y: 50, // Khoảng cách từ cạnh trên của màn hình
                },
            }).showToast();

        }


    }
   });


}