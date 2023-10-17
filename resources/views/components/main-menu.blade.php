<div class="menu-gold " style="z-index: 10000;">
    <ul class="menu">
        @foreach ($list_menu as $row_menu)
        <x-sub1-main-menu :rowmenu="$row_menu"/>
        @endforeach
    </ul>
</div>