{{-- <div class="row">
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
</div> --}}
<div class="row">
    <div class="form_images">
        <div class="card">
            <div class="top">
                <p>Kéo và thả để thêm ảnh</p>
                
                
            </div>
            <div class="drag-area">
                <span class="visible">
                    Kéo và thả ảnh vảo đây hoặc
                    <span class="select" role="button">Thêm</span>
                </span>
                <span class="on-drop">Thả ra</span>
                <input name="images[]" type="file" class="file" multiple />
                <input type="hidden" id="imageData" value="{{ json_encode($imageData) }}">
            </div>

            <div class="container"> @if ($errors->has('images'))
                <div class="text-danger">
                    {{ $errors->first('images') }}
                </div>
            @endif</div>
        </div>
    </div>
   
   

</div>