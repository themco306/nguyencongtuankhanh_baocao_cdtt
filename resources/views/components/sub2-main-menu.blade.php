@if ($checksub)
                <li><a href="{{ route('slug.index',['slug'=>$row_menu1->link]) }}"> {{ $row_menu1->name }}</a>
                    <ul>
                         @foreach ($list_menu2 as $row_menu2)
                        <li>
                            <a href="{{ route('slug.index',['slug'=>$row_menu2->link]) }}"> {{ $row_menu2->name }}</a>
                        </li>
                        @endforeach
                    </ul>
                </li>
                @else
                <li>
                    <a href="{{ route('slug.index',['slug'=>$row_menu1->link]) }}"> {{ $row_menu1->name }}</a>
                </li>
                @endif