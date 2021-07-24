<ul>

    @foreach($items as $menu_item)
        <li>
            @unless(preg_match_all('/(?=fa-)+/' , $menu_item->title))
            {{ $menu_item->title  }}
            @endunless
            <a href="{{ $menu_item->link() }}">
               <i class="fa {{ $menu_item->title }} " ></i>
            </a>
        </li>
    @endforeach
</ul>
