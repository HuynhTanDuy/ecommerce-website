<ul>
    @foreach($items as $menu_item)
        @if ($menu_item->title === 'Follow Me:')
            <li>Liên hệ: </li>
        @endif
        <li><a href="{{ $menu_item->link() }}"><i class="fa {{ $menu_item->title }}"></i></a></li>
    @endforeach
</ul>
