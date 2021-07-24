<ul>
    @guest
        <li>
            <a href="{{ route('login') }}">Login</a>
        </li>
        <li>
            <a href="{{ route('register') }}">Sign Up</a>
        </li>
    @else

        <li><a href="{{ route('users.edit') }}">My Account</a></li>
        <li>
            <a href="#" onclick=" document.querySelector('#form-logout').submit() ">Logout</a>

            <form action="{{ route('logout') }}" method="POST" id="form-logout" style="display: none">
                @csrf
            </form>
        </li>
    @endguest
    <li>
        <a href="{{ route('cart.index') }}">Cart

            @if(Cart::instance('default')->count() > 0)

                <span class="cart-count">
                            <i class="fa fa-shopping-cart">
                  {{Cart::instance('default')->count()}}
                            </i>
                    </span>

            @endif
        </a>
    </li>
</ul>
