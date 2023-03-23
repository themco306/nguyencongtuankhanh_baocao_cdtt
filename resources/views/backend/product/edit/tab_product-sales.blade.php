<div class="row">
    <div class="col-7 mb-3 ">
        <label for="price_sale">Giá khuyến mãi</label>
        <input name="price_sale" id="numberInput" value="{{ old('price_sale',$product->price_sale) }}"
            type="number" class="form-control ">
        @if ($errors->has('price_sale'))
            <div class="text-danger">
                {{ $errors->first('price_sale') }}
            </div>
        @endif
    </div>
    <div class="col-7 mb-3">
        <label for="date_begin">Ngày bắt đầu</label>
        <input name="date_begin" id="date_begin" value="{{ old('date_begin',isset($product->date_begin) ? \Carbon\Carbon::parse($product->date_begin)->format('Y-m-d') : null) }}"
            type="date" class="form-control ">
         
        @if ($errors->has('date_begin'))
            <div class="text-danger">
                {{ $errors->first('date_begin') }}
            </div>
        @endif
    </div>
    <div class="col-7 mb-3">
        <label for="date_end">Ngày kết thúc</label>
        <input name="date_end" id="date_end" value="{{ old('date_end',isset($product->date_begin) ? \Carbon\Carbon::parse($product->date_end)->format('Y-m-d') : null) }}"
            type="date" class="form-control ">
        @if ($errors->has('date_end'))
            <div class="text-danger">
                {{ $errors->first('date_end') }}
            </div>
        @endif
    </div>
</div>
