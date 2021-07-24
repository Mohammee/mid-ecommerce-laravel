<header>
    <div class="top-nav container">

        <div class="top-nav-left">
            <div class="logo"><a href="{{route('landing-page')}}">Ecommerce</a></div>
            @if (! (request()->is('checkout') || request()->is('guestCheckout')))
                {{--            <ul>--}}
                {{--                <li><a href="{{route('shop.index')}}">Shop</a></li>--}}
                {{--                <li><a href="#">About</a></li>--}}
                {{--                <li><a href="#">Blog</a></li>--}}
                {{--                <li><a href="{{route('cart.index')}}">--}}
                {{--                        Cart--}}
                {{--                        @if(Cart::instance('default')->count() > 0)--}}
                {{--                            <span class="cart-count"><span> <i class="fa fa-shopping-cart">--}}
                {{--                                {{Cart::instance('default')->count()}}--}}
                {{--                            </i></span></span>--}}
                {{--                        @endif--}}
                {{--                    </a>--}}
                {{--                </li>--}}
                {{--            </ul>--}}

                {{ menu('main' , 'partials.menus.main') }}

            @endif
        </div>

        <div class="top-nav-right">
            @if (! (request()->is('checkout') ||  request()->is('guestCheckout')))
                @include('partials.menus.main-right')
            @endif
        </div>
    </div> <!-- end top-nav -->
</header>
