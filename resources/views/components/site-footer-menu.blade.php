
@foreach($list_menu as $fmenu)
<li >
    <a href="{{ route('slug.index',['slug'=>$fmenu->link]) }}">
        {{ $fmenu->name }}
    </a>
</li>
@endforeach