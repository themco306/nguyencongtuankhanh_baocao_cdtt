@php
    use App\Models\Menu;
$arg_mainmenu1 = [['parent_id', '=', 0],
    ['status', '=', 1],
    ['position', '=', 'mainmenu']];
$list_menu = Menu::where($arg_mainmenu1)->orderBy('sort_order', 'asc')->get();
@endphp

<div class="menu-gold " style="z-index: 10000;">
    <ul class="menu">
        @foreach ($list_menu as $row_menu)
        @php
            $arg_mainmenu2 = [['parent_id', '=', $row_menu->id],
    ['status', '=', 1],
    ['position', '=', 'mainmenu']];
        $list_menu1 = Menu::where($arg_mainmenu2)->orderBy('sort_order', 'asc')->get();
        @endphp 
    @if (count($list_menu1) != 0)
        <li>
            <a href="{{ $row_menu->link }}"> {{ $row_menu->name }}</a>
            <ul>
                @foreach ($list_menu1 as $row_menu1)
                @php $arg_mainmenu3 = [['parent_id', '=', $row_menu1->id],
    ['status', '=', 1],
    ['position', '=', 'mainmenu']];
    $list_menu2 = Menu::where($arg_mainmenu3)->orderBy('sort_order', 'asc')->get();
        @endphp
        @if (count($list_menu2) != 0)
                <li><a href="{{  $row_menu1->link}}"> {{ $row_menu1->name }}</a>
                    <ul>
                         @foreach ($list_menu2 as $row_menu2)
                        <li>
                            <a href="{{ $row_menu2->link }}"> {{ $row_menu2->name }}</a>
                        </li>
                        @endforeach
                    </ul>
                </li>
                @else
                <li>
                    <a href="{{ $row_menu1->link }}"> {{ $row_menu1->name }}</a>
                </li>
                @endif
                @endforeach
            </ul>
        </li>
        @else
        <li>
            <a href="{{ $row_menu->link }}"> {{ $row_menu->name }}</a>
        </li>
        @endif
        @endforeach
    </ul>
</div>






