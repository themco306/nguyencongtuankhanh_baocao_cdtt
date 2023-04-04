@if ($checksub)
        <li>
            <a href="{{ route('slug.index',['slug'=>$row_menu->link]) }}"> {{ $row_menu->name }}</a>
            <ul>
                @foreach ($list_menu1 as $row_menu1)
               <x-sub2-main-menu :rowmenu1="$row_menu1"/>
        
                @endforeach
            </ul>
        </li>
        @else
        <li>
            <a href="{{ route('slug.index',['slug'=>$row_menu->link]) }}"> {{ $row_menu->name }}</a>
        </li>
        @endif