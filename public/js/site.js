function updateHeartIcons() {
    var badges = document.querySelectorAll(".badge");
    if (localStorage.getItem('data') != null) {
        var data = JSON.parse(localStorage.getItem('data'));
        for (var i = 0; i < badges.length; i++) {
            badges[i].textContent = data.length;
        }
        var productIds = data.map(function (item) {
            return item.id;
        });
        // Lặp qua tất cả các sản phẩm
        productIds.forEach(function (id) {
            // Kiểm tra xem sản phẩm có tồn tại trong localStorage hay không
            var productExists = data.some(function (item) {
                return item.id == id;
            });

            // Nếu sản phẩm tồn tại, thay đổi màu sắc của biểu tượng trái tim
            if (productExists) {
                document.querySelector('#heart-icon' + id).setAttribute('fill', '#FF4C26');
            }
        });
    }
    // Lấy dữ liệu từ localStorage
}

// Gọi hàm updateHeartIcons khi trang web tải xong
document.addEventListener('DOMContentLoaded', function () {
    // Thay đổi mảng này để chứa id của tất cả các sản phẩm
    updateHeartIcons();

});


function view(){
    if(localStorage.getItem('data')!=null){
        var data = JSON.parse(localStorage.getItem('data'));
        data.reverse();

        document.getElementById('row_wishlist').style.overflowY ='scroll';
        document.getElementById('row_wishlist').style.overflowX ='hidden';
        document.getElementById('row_wishlist').style.maxHeight ='350px';
        for(i=0;i<data.length;i++){
            var id = data[i].id;
            var name = data[i].name;
            var price = data[i].price;
            var url = data[i].url;
            var image = data[i].image;
            $('#row_wishlist,#row_wishlist_2').append('<div class="row  my-2"><i onclick="del_wishlist(this.id)" id="'+id+'" class="fa-solid fa-circle-xmark fa-bounce"></i><div class="col-md-8 fs-6"><p style="color:#2F2F2F  ;" class="fw-bold">'+name+'</p><span style="color:#FFAD03 ;">'+price+'</span><a class="ms-2" style="color:#1BBCEF ;"  href="'+url+'">Xem...</a></div><div class="col-md-4 "><img class="img-fluid" src="'+image+'"></div></div>');

        }

        
    }
}
view();

function del_wishlist(del_id) {
    var id = del_id;
    var data = JSON.parse(localStorage.getItem('data'));
    data = data.filter(function(item) {
        return item.id !== id;
    });
    localStorage.setItem('data', JSON.stringify(data));
    location.reload();
}
function fill_heart(fill_id){
    var id=fill_id;
    var heartIcon = document.querySelector('#heart-icon' + id);
    heartIcon.setAttribute('fill', '#FF4C26');
    heartIcon.style.transform = 'scale(0.8)';
    setTimeout(function () {
        heartIcon.style.transform = 'scale(1)';
    }, 500);
}
function add_wishlist(clicked_id) {
    var id = clicked_id;
    var name = document.getElementById('wishlist_product-name' + id).value;
    var price = document.getElementById('wishlist_product-price' + id).value;
    var image = document.getElementById('wishlist_product-image' + id).src;
    var url = document.getElementById('wishlist_product-url' + id).href;

    fill_heart(id);
    var newItem = {
        'id': id,
        'name': name,
        'price':price,
        'url': url,
        'image': image,

    };
    if (localStorage.getItem('data') == null) {
        localStorage.setItem('data', '[]');
    }
    var old_data = JSON.parse(localStorage.getItem('data'));
    var matches = old_data.filter(function (obj) {
        return obj.id == id;
    });

    if (matches.length) {
        alert("Đã thêm rồi");
    }
    else {
        old_data.push(newItem);
        var badge = document.getElementById("badge");
        var currentValue = isNaN(parseInt(badge.textContent)) ? 0 : parseInt(badge.textContent);
        var badges = document.querySelectorAll(".badge");
        for (var i = 0; i < badges.length; i++) {
            badges[i].textContent = currentValue + 1;
        }
        $('#row_wishlist,#row_wishlist_2').append('<div class="row  py-1"><i onclick="del_wishlist(this.id)" id="'+newItem.id+'" class="fa-solid fa-circle-xmark"></i><div class="col-md-7 fs-6"><p style="color:#2F2F2F  ;" class="fw-bold">'+newItem.name+'</p><span style="color:#FFAD03 ;">'+newItem.price+'</span><a class="ms-2" style="color:#1BBCEF ;"  href="'+url+'">Xem...</a></div><div class="col-md-4 m-1"><img class="img-fluid" src="'+newItem.image+'"></div></div>');
    }
    localStorage.setItem('data', JSON.stringify(old_data));
}