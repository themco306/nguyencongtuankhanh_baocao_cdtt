document.addEventListener("DOMContentLoaded", function () {
    // Lấy giá trị ban đầu của product_id
    var productId =$("#product_id").val()

    // Gọi hàm getProductQty() với giá trị ban đầu của productId
    getProductQty(productId);

    // Lắng nghe sự kiện thay đổi của product_id
    $("#product_id").on("change.select2", function () {
        var productId = $(this).val();
        var newUrl = window.location.href;
        var updatedUrl = newUrl.replace(/\/\d+$/, '/' + productId);

        window.history.replaceState(null, null, updatedUrl);
        getProductQty(productId);
    });
});

function getProductQty(productId) {
    // var url =  "qty/" +productId ;
    var baseUrl = document.getElementById('product_qty_url').value;
    var url = baseUrl +'/'+ productId;
    fetch(url)
        .then((response) => response.json())
        .then((data) => {
            document.getElementById("qty_base").value = data.qty;
        })
        .catch((error) => {
            console.error("Error:", error);
        });
}
