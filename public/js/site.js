
var user_id = document.getElementById('get_user_ls').value;
function updateHeartIcons() {
    var badges = document.querySelectorAll(".badge");
    if (localStorage.getItem('data_wishlist' + user_id) != null) {
        var data = JSON.parse(localStorage.getItem('data_wishlist' + user_id));
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
                var heartIcons = document.querySelectorAll('.heart-icon' + id);
                heartIcons.forEach(function (heartIcon) {
                    heartIcon.setAttribute('fill', '#FF4C26');
                });
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
view();
function view() {

    if (localStorage.getItem('data_wishlist' + user_id) != null) {
        var data = JSON.parse(localStorage.getItem('data_wishlist' + user_id));
        data.reverse();
        document.getElementById('row_wishlist').style.overflowY = 'scroll';
        document.getElementById('row_wishlist').style.overflowX = 'hidden';
        document.getElementById('row_wishlist').style.maxHeight = '350px';
        data.forEach(function (item) {
            var id = item.id;
            var name = item.name;
            var price = item.price;
            var url = item.url;
            var image = item.image;
            $('#row_wishlist_2,#row_wishlist').append('<div   class="row  my-2 wishlist_item_' + id + '"><i onclick="del_wishlist(this.id)" id="' + id + '" class="fa-solid fa-circle-xmark fa-bounce"></i><div class="col-md-8 fs-6"><p style="color:#2F2F2F  ;" class="fw-bold">' + name + '</p><span style="color:#FFAD03 ;">' + price + '</span><a class="ms-2" style="color:#1BBCEF ;"  href="' + url + '">Xem...</a></div><div class="col-md-4 "><img class="img-fluid" src="' + image + '"></div></div>');
        });
    }
    else {
        if (localStorage.getItem('data_wishlist_temporary') != null) {
            var old_data = JSON.parse(localStorage.getItem('data_wishlist_temporary'));
            localStorage.setItem('data_wishlist' + user_id, '[]');
            localStorage.setItem('data_wishlist' + user_id, JSON.stringify(old_data));
            localStorage.removeItem('data_wishlist_temporary');

        }
    }

}


function del_wishlist(del_id) {
    var id = del_id;
    console.log("xóa"+id)
    var wishlistItems = document.querySelectorAll('.wishlist_item_'+id);
    for (var i = 0; i < wishlistItems.length; i++) {
            wishlistItems[i].remove();
    }
    var data = JSON.parse(localStorage.getItem('data_wishlist' + user_id));
    data = data.filter(function (item) {
        return item.id !== id;
    });
    localStorage.setItem('data_wishlist' + user_id, JSON.stringify(data));

    // Xóa phần tử HTML tương ứng với sản phẩm khỏi danh sách yêu thích
    
     var badge = document.getElementById("badge");

        var badges = document.querySelectorAll(".badge");
        var currentValue = isNaN(parseInt(badge.textContent)) ? 0 : parseInt(badge.textContent);
        for (var i = 0; i < badges.length; i++) {
            badges[i].textContent = currentValue - 1;
        }
    un_fill_heart(id)
}
function un_fill_heart(fill_id){
    var id = fill_id;
    var heartIcons = document.querySelectorAll('.heart-icon' + id);
    heartIcons.forEach(function (heartIcon) {
        heartIcon.style.setProperty('fill', 'rgba(36, 23, 0, 0.747)', 'important');
        heartIcon.style.setProperty('transform', 'scale(0.8)', 'important');
        setTimeout(function () {
            heartIcon.style.setProperty('transform', 'scale(1)', 'important');
        }, 500);
    });
}
function fill_heart(fill_id) {
    var id = fill_id;
    var heartIcons = document.querySelectorAll('.heart-icon' + id);
    heartIcons.forEach(function (heartIcon) {
        heartIcon.style.setProperty('fill', '#FF4C26', 'important');
        heartIcon.style.setProperty('transform', 'scale(0.8)', 'important');
        setTimeout(function () {
            heartIcon.style.setProperty('transform', 'scale(1)', 'important');
        }, 500);
    });
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
        'price': price,
        'url': url,
        'image': image,

    };
    if (localStorage.getItem('data_wishlist' + user_id) == null) {
        localStorage.setItem('data_wishlist' + user_id, '[]');
    }
    var old_data = JSON.parse(localStorage.getItem('data_wishlist' + user_id));
    var matches = old_data.filter(function (obj) {
        return obj.id == id;
    });

    if (matches.length) {
        // Nếu sản phẩm đã được yêu thích, hãy bỏ yêu thích
        old_data = old_data.filter(function (item) {
            return item.id !== id;
        });
        var wishlistItems = document.querySelectorAll('.wishlist_item_'+id);
        for (var i = 0; i < wishlistItems.length; i++) {
                wishlistItems[i].remove();
        }
        localStorage.setItem('data_wishlist' + user_id, JSON.stringify(old_data));
        // Xóa phần tử HTML tương ứng với sản phẩm khỏi danh sách yêu thích
        
        var badge = document.getElementById("badge");

        var badges = document.querySelectorAll(".badge");
        var currentValue = isNaN(parseInt(badge.textContent)) ? 0 : parseInt(badge.textContent);
        for (var i = 0; i < badges.length; i++) {
            badges[i].textContent = currentValue - 1;
        }
        // Bỏ fill màu cho biểu tượng trái tim
        un_fill_heart(id)
        // del_wishlist(id)
    }
    else {
        old_data.push(newItem);
        $('#row_wishlist_2,#row_wishlist').append('<div  class="row  py-1 wishlist_item_' + newItem.id + '"><i onclick="del_wishlist(this.id)" id="' + newItem.id + '" class="fa-solid fa-circle-xmark"></i><div class="col-md-7 fs-6"><p style="color:#2F2F2F  ;" class="fw-bold">' + newItem.name + '</p><span style="color:#FFAD03 ;">' + newItem.price + '</span><a class="ms-2" style="color:#1BBCEF ;"  href="' + url + '">Xem...</a></div><div class="col-md-4 m-1"><img class="img-fluid" src="' + newItem.image + '"></div></div>');
        var badge = document.getElementById("badge");
        var currentValue = isNaN(parseInt(badge.textContent)) ? 0 : parseInt(badge.textContent);
        var badges = document.querySelectorAll(".badge");
        for (var i = 0; i < badges.length; i++) {
            badges[i].textContent = currentValue + 1;
        }
        
    }
    localStorage.setItem('data_wishlist' + user_id, JSON.stringify(old_data));

}
// function add_wishlist(clicked_id) {
//     var id = clicked_id;
//     var name = document.getElementById('wishlist_product-name' + id).value;
//     var price = document.getElementById('wishlist_product-price' + id).value;
//     var image = document.getElementById('wishlist_product-image' + id).src;
//     var url = document.getElementById('wishlist_product-url' + id).href;

//     if (localStorage.getItem('data_wishlist' + user_id) == null) {
//         localStorage.setItem('data_wishlist' + user_id, '[]');
//     }
//     var old_data = JSON.parse(localStorage.getItem('data_wishlist' + user_id));
//     var matches = old_data.filter(function (obj) {
//         return obj.id == id;
//     });

//     if (matches.length) {
//         // Nếu sản phẩm đã được yêu thích, hãy bỏ yêu thích
//         old_data = old_data.filter(function (item) {
//             return item.id !== id;
//         });
//         localStorage.setItem('data_wishlist' + user_id, JSON.stringify(old_data));
//         // Xóa phần tử HTML tương ứng với sản phẩm khỏi danh sách yêu thích
//         var wishlistItem = document.getElementById('wishlist_item_' + id);
//         if (wishlistItem) {
//             wishlistItem.remove();
//         }
//         // Bỏ fill màu cho biểu tượng trái tim
//         var heartIcons = document.querySelectorAll('.heart-icon' + id);
//         heartIcons.forEach(function (heartIcon) {
//             heartIcon.style.setProperty('fill', 'rgba(36, 23, 0, 0.747)', 'important');
//         });
//     } else {
//         // Nếu sản phẩm chưa được yêu thích, hãy thêm vào danh sách yêu thích
//         var newItem = {
//             'id': id,
//             'name': name,
//             'price': price,
//             'url': url,
//             'image': image,
//         };
//         old_data.push(newItem);
//         localStorage.setItem('data_wishlist' + user_id, JSON.stringify(old_data));
//         fill_heart(id);
//     }
// }
