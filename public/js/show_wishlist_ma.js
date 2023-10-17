view_show_wishlist();
function view_show_wishlist(){
    if(localStorage.getItem('data_wishlist'+user_id)!=null){
        var data = JSON.parse(localStorage.getItem('data_wishlist'+user_id));
        data.reverse();
        
        data.forEach(function(item) {
            var id = item.id;
            var name = item.name;
            var price = item.price;
            var url = item.url;
            var image = item.image;
            $('#show_wishlist').append('<tr><th class="align-middle" scope="row"><i onclick="del_wishlist(this.id)" id="'+id+'" class="fa-solid fa-circle-xmark "></i></th><td class="align-middle"><img class="img-fluid" src="'+image+'"></td><td class="align-middle"><a href="'+url+'" class="fw-200">'+name+'</a></td><td class=" align-middle"><span style="color:#FFAD03 ;">'+price+'</span></td><td class="align-middle"><a class="btn_addcart" onclick="addCart(this.id)" value="'+id+'" >Thêm vào giỏ</a></td></tr>');
        });
    }
}