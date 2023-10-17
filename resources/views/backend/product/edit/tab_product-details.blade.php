<div class="mb-3">
    <label for="detail">Chi tiết</label>
    <textarea name="detail" id="detail" cols="10" rows="2" class="form-control " 
        placeholder="Chi tiết">{{ old('detail',$product->detail) }}</textarea>
        @if ($errors->has('detail'))
        <div class="text-danger">
        {{ $errors->first('detail') }}
        </div>    
        @endif
</div>
<script>
    CKEDITOR.replace('detail')
</script>