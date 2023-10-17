$(document).ready(function () {
    $(".minus-btn").click(function (e) {
        e.preventDefault();
        var amountInput = $(this).closest(".form-qty").find(".amount");
        var value = parseInt(amountInput.val(), 10);
        value = isNaN(value) ? 1 : value;
        if (value > 1) {
            value--;
            amountInput.val(value);
        }
    });
    $(".plus-btn").click(function (e) {
        e.preventDefault();
        var amountInput = $(this).closest(".form-qty").find(".amount");
        var qty_max = $(this).closest(".form-qty").find(".qty_max").val();
        var value = parseInt(amountInput.val(), 10);
        value = isNaN(value) ? 1 : value;
        if (value < qty_max) {
            value++;
            amountInput.val(value);
        }
    });
    $(".amount").on("input", function () {
        var qty_max = $(this).closest(".form-qty").find(".qty_max").val();
        var value = parseInt($(this).val());
        value = isNaN(value) || value == 0 ? 1 : value;
        value = value > qty_max ? qty_max : value;
        $(this).val(value);
        
    });
    $(".delete-cart-item").click(function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        });
        var product_id = $(this).closest(".form-qty").find(".product_id").val();
       $.ajax({
        type: "POST",
        url: "xoa-gio-hang",
        data: {
            'product_id':product_id,
        },
       
        success: function (response) {
           
            if (response.success) {
                swal("Thành công!!", response.success, "success", { timer: 10000 }).then(function () {
                    window.location.reload();
                });
            } else {
                swal("Thông báo!!", response.alert, { timer: 10000 }).then(function () {
                    window.location.reload();
                });
            }
        }
       });
    });
    $('.changeqty').click(function (e) { 
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        });
        var product_id = $(this).closest(".form-qty").find(".product_id").val();
        var qty = $(this).closest(".form-qty").find(".amount").val();
        $.ajax({
            type: "POST",
            url: "cap-nhat-gio-hang",
            data: {
                'product_id':product_id,
                'qty':qty,
            },
          
            success: function (response) {
                
                window.location.reload();

                
            }
        });
        
    });
});
