document.addEventListener("DOMContentLoaded", function () {
   load()
});

function load(){
    // Lấy giá trị ban đầu của product_id
    var productId =$("#product_id").val()

    // Gọi hàm getProductQty() với giá trị ban đầu của productId
    getProductInfo(productId);

    // Lắng nghe sự kiện thay đổi của product_id
    $("#product_id").on("change.select2", function () {
        var productId = $(this).val();
        var newUrl = window.location.href;
        var updatedUrl = newUrl.replace(/\/\d+$/, '/' + productId);
        window.history.replaceState(null, null, updatedUrl);
        setPriceEnd($("#discount").val())
        getProductInfo(productId);
    });
    $("#discount").on("keydown", function (e) {
        if (e.key === "-") {
          e.preventDefault(); // Ngăn trình duyệt xử lý sự kiện mặc định
          var currentValue = $(this).val();
          var modifiedValue = currentValue.replace("-", ""); // Xóa dấu "-"
          $(this).val(modifiedValue); // Gán lại giá trị đã chỉnh sửa vào trường discount
         
        }
      });
    $("#discount").on("input", function  () {
        var discount = $(this).val();
        if (discount > 100) {
            discount = 100;
            $(this).val(discount); // Đặt lại giá trị trường discount thành 100
          } else if (discount < 0) {
            discount = 0;
            $(this).val(discount); // Đặt lại giá trị trường discount thành 0
          }
        setPriceEnd(discount);
      });
      $("#qty").on("keydown", function (e) {
        if (e.key === "-") {
          e.preventDefault(); // Ngăn trình duyệt xử lý sự kiện mặc định
          var currentValue = $(this).val();
          var modifiedValue = currentValue.replace("-", ""); // Xóa dấu "-"
          $(this).val(modifiedValue); // Gán lại giá trị đã chỉnh sửa vào trường discount
         
        }
      });
      $("#qty").on("input", function() {
        var qtyValue = parseInt($(this).val()); // Lấy giá trị số từ trường qty
        var qtyBaseValue = parseInt($("#qty_base").val()); // Lấy giá trị số từ trường qty_base
    
        if (qtyValue > qtyBaseValue) {
            $(this).val(qtyBaseValue); // Đặt lại giá trị trường qty thành giá trị của qty_base nếu qtyValue > qtyBaseValue
           
        } 
    });
}
function setPriceEnd(discount) {
    var priceSelling = parseFloat(document.getElementById("price_selling").value);
    var calculatedDiscount = parseFloat(discount) / 100;
    var priceEnd =priceSelling-( priceSelling * calculatedDiscount);
    document.getElementById("price_end").value = priceEnd;
  }
function getProductInfo(productId) {
    // var url =  "qty/" +productId ;
    var baseUrl = document.getElementById('product_info_url').value;
    var url = baseUrl +'/'+ productId;
    console.log(url)
    fetch(url)
        .then((response) => response.json())
        .then((data) => {
            console.log(data);
            document.getElementById("qty_base").value = data.qty_base;
            document.getElementById("price_base").value = data.price_base;
            document.getElementById("price_selling").value = data.price_selling;
            
        })
        .catch((error) => {
            console.log("Error:", error);
        });
}
