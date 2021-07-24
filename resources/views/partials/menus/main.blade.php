<ul>
    @foreach($items as $menu_item)

        <li>
            <a href="{{ $menu_item->link() }}">
                {{ $menu_item->title }}
{{--                @if($menu_item->title === 'Cart' && Cart::instance('default')->count() > 0)--}}

{{--                    <span class="cart-count">--}}
{{--                            <i class="fa fa-shopping-cart">--}}
{{--                  {{Cart::instance('default')->count()}}--}}
{{--                            </i>--}}
{{--                    </span>--}}

{{--                @endif--}}
            </a>
        </li>
    @endforeach
</ul>
