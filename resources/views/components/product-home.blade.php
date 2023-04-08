<div>
    <div class="product_cate ">

            <div id="" class="h4 pb-2 mb-4  border-bottom border-danger fst-italic">
                <a class="title" href="{{ route('slug.index',['slug'=>$cat->slug]) }}"> {{ $cat->name }}(Xem thêm...)</a>
            </div>
    
            <div class="product my-3">
                <div class="row">
                    @foreach($list_product as $product)
                            <x-product-item :productitem="$product"/>
                    @endforeach
                </div>
            </div>
    </div>
</div>