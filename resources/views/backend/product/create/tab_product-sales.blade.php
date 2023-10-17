<div class="row">
    <div class="col-7 mb-3 ">
        <label for="discount">Giá khuyến mãi</label>
        <input name="discount" id="discount" value="{{ old('discount') }}"
            type="number" class="form-control ">
        @if ($errors->has('discount'))
            <div class="text-danger">
                {{ $errors->first('discount') }}
            </div>
        @endif
    </div>
    <div class="col-7 mb-3">
        <label for="date_begin">Ngày bắt đầu</label>
        <input name="date_begin" id="date_begin" value="{{ old('date_begin') }}"
            type="date" class="form-control ">
        @if ($errors->has('date_begin'))
            <div class="text-danger">
                {{ $errors->first('date_begin') }}
            </div>
        @endif
    </div>
    <div class="col-7 mb-3">
        <label for="date_end">Ngày kết thúc</label>
        <input name="date_end" id="date_end" value="{{ old('date_end') }}"
            type="date" class="form-control ">
        @if ($errors->has('date_end'))
            <div class="text-danger">
                {{ $errors->first('date_end') }}
            </div>
        @endif
    </div>
</div>