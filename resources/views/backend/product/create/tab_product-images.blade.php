<div class="row">
        {{-- <div class="form_images">
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
					<input name="images[]" id="imageData" type="file" class="file" multiple />
				</div>

				<div class="container"> @if ($errors->has('images'))
					<div class="text-danger">
						{{ $errors->first('images') }}
					</div>
				@endif</div>
			</div>
		</div> --}}
       
		<input name="images[]" id="imageData" type="file" class="file" multiple />

</div>
