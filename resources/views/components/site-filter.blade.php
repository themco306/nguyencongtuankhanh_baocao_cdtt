<div class="filter-price">
    <form action="" method="get">
        @csrf
    <p>Lọc Theo Giá</p>
    <div class="group ">
        <div class="progress"></div>
        <div class="range-input">
          <input type="range" class="range-min" min="0" max="10000000" value="0" step="1000">
          <input type="range" class="range-max" min="0" max="10000000" value="10000000" step="1000">
        </div>
        <div class="text-range">
          <div class="text-min">0</div>
          <div class="text-max">10.000.000</div>
        </div>
     </div>
     <div class="mb-2 mt-5 text-end"> <button class="btn btn-sm btn-success">Lọc</button></div>
    
    </form>
</div>
<div class="filter-category">
    <p>Danh Mục Sản Phẩm</p>
    <ul>
        @foreach ($list_category as $item)
        <li>
            <a href="{{ route('slug.index',['slug'=>$item->slug]) }}">
                <i class="fa-solid  {{ ($item->slug==$slugselect) ?'fa-folder-open fa-beat-fade':'fa-folder' }}  p-1" >
                </i>
                {{ $item->name }}
            </a>
        </li>
        @endforeach
    </ul>
</div>
<div class="filter-brand">
    <p>Thương Hiệu</p>
    <ul>
        @foreach ($list_brand as $item)
        <li>
            <a href="{{ route('slug.index',['slug'=>$item->slug]) }}">
                <i class="fa-solid  {{ ($item->slug==$slugselect) ?'fa-folder-open fa-beat-fade':'fa-folder' }}  p-1" >
                </i>
                {{ $item->name }}
            </a>
        </li>
        @endforeach
    </ul>
</div>