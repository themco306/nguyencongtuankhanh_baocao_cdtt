<div class="row">
    <div class="col-6">
        <div class="container-image">
            <input name="images[]" id="file-input" type="file" multiple
                value="{{ old('images.*') }}" class="form-control btn-sm">
            <label for="file-input">
                <i class="fa-solid fa-arrow-up-from-bracket"></i>
                &nbsp; Hình ảnh mô tả
            </label>
            <div id="num-of-files">
                @if ($errors->has('images[]'))
                    <div class="text-danger">
                        {{ $errors->first('images[]') }}
                    </div>
                @else
                    <div class="text-danger">
                        Chưa Có Ảnh
                    </div>
                @endif
            </div>
            <ul id="files-list"></ul>
        </div>
    </div>
</div>