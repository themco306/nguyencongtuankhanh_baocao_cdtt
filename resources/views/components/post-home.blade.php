
    <div class="row">
        @foreach($list_post as $post)
        <div class="col-md-3 col-12">
        <x-post-item :rowpost="$post"/>
        </div>
    @endforeach
</div>
