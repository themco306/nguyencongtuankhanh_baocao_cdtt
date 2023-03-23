<div class="row">
    <div class="col-md-8">
        <div class="mb-3">
            <label for="name">Tên sản phẩm</label>
            <input name="name" id="name" value="{{ old('name',$product->name) }}" type="text" class="form-control "
                placeholder="vd:Luffy">
            @if ($errors->has('name'))
                <div class="text-danger">
                    {{ $errors->first('name') }}
                </div>
            @endif

        </div>


        <div class="mb-3 ">
            <label for="metadesc">Mô tả (SEO)</label>
            <textarea name="metadesc" id="metadesc" cols="10" rows="5" class="form-control " placeholder="vd: ">{{ old('metadesc',$product->metadesc) }}</textarea>
            @if ($errors->has('metadesc'))
                <div class="text-danger">
                    {{ $errors->first('metadesc') }}
                </div>
            @endif
        </div>
        <div class=" mb-3">
            <label for="metakey">Từ khóa (SEO)</label>
            <textarea name="metakey" id="metakey" cols="10" rows="4" class="form-control " placeholder="vd: ">{{ old('metakey',$product->metakey) }}</textarea>
            @if ($errors->has('metakey'))
                <div class="text-danger">
                    {{ $errors->first('metakey') }}
                </div>
            @endif
        </div>




    </div>
    <div class="col-md-4">

        <div class="mb-3">
            <label for="category_id">Danh mục</label>
            <select name="category_id" id="category_id" class="form-control">
                {!! $str_option_category !!}
            </select>
        </div>
        <div class="mb-3">
            <label for="brand_id">Brand</label>
            <select name="brand_id" id="brand_id" class="form-control">
                {!! $str_option_brand !!}
            </select>
        </div>
        <div class="mb-3">
            <label for="qty">Số lượng </label>
            <input name="qty" id="qty" type="number" class="form-control " value="{{ old('qty',$product->qty) }}">
            @if ($errors->has('qty'))
                <div class="text-danger">
                    {{ $errors->first('qty') }}
                </div>
            @endif
        </div>
        <div class="mb-3">
            <label for="price">Giá</label>
            <input name="price" id="price" type="number" class="form-control" value="{{ old('price',$product->price) }}">
            @if ($errors->has('price'))
                <div class="text-danger">
                    {{ $errors->first('price') }}
                </div>
            @endif
        </div>

        <div class="mb-3">
            <label for="status">Trạng thái</label>
            <select name="status" id="status" class="form-control">
                <option value="1"  {{ (old('status',$product->status) == 1) ? 'selected' : ''; }}>
                    Xuất bản</option>
                <option value="2"  {{ (old('status',$product->status) == 2) ? 'selected' : ''; }}>
                    Chưa xuất bản</option>

            </select>
        </div>
    </div>
</div>
