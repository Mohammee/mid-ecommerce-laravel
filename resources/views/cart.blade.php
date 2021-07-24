@extends('layout')

@section('title', 'Shopping Cart')

@section('extra-css')

    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection

@section('content')

    <x-breadcrumbs>
        <a href="{{route('landing-page')}}">Home</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>Shopping Cart</span>
    </x-breadcrumbs><!-- end breadcrumbs -->


    <div class="cart-section container">
        <div>


            @if(session()->has('success_message'))
                <div class="alert alert-success">
                    {{session()->get('success_message')}}
                </div>
            @endif

            @if(count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(Cart::instance('default')->count() > 0)

                <h2>{{Cart::instance('default')->count()}} item(s) in Shopping Cart</h2>


                <div class="cart-table">

                    @foreach(Cart::instance('default')->content() as $item)
                        <div class="cart-table-row">
                            <div class="cart-table-row-left">
                                <a href="{{route('shop.show', $item->model->slug)}}"><img
                                        src="{{ productImage($item->model->image) }}"
                                        alt="{{$item->model->name}}" class="cart-table-img"></a>
                                <div class="cart-item-details">
                                    <div class="cart-table-item"><a href="{{route('shop.show', $item->model->slug)}}">
                                            {{$item->model->name}}</a>
                                    </div>
                                    <div class="cart-table-description">{{$item->model->details}}</div>
                                </div>
                            </div>
                            <div class="cart-table-row-right">
                                <div class="cart-table-actions">

                                    <form action="{{route('cart.destroy' ,$item->rowId )}}" method="POSt">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="cart-options">Remove</button>
                                    </form>

                                    {{--                                    <a href="#">Save for Later</a>--}}

                                    <form action="{{route('cart.switchToSaveForLater',$item->rowId)}}" method="POST">
                                        @csrf
                                        <button type="submit" class="cart-options">Save for Later</button>
                                    </form>

                                </div>
                                <div>
                                    <select class="quantity" data-id="{{$item->rowId}}" data-productQuantity="{{ $item->model->quantity }}">
                                        @for($i = 1 ; $i <= 5 ; $i++)
                                            <option
                                                {{ $item->qty == $i ? 'selected' : '' }} value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="subtotal">${{ formatPrice($item->subtotal()) }}</div>
                            </div>
                        </div> <!-- end cart-table-row -->

                    @endforeach

                </div> <!-- end cart-table -->

                @unless(session()->has('coupon'))
                    <a href="#" class="have-code">Have a Code?</a>

                    <div class="have-code-container">
                        <form action="{{ route('coupon.store') }}" method="POST">
                            @csrf
                            <input type="text" name="coupon_code" id="coupon_code">
                            <input type="submit" class="button" value="Apply">
                        </form>
                    </div> <!-- end coupon input -->

                @endunless

                <div class="cart-totals">

                    <div class="cart-totals-left">
                        Shipping is free because we’re awesome like that. Also because that’s additional stuff I don’t
                        feel like figuring out :).
                    </div>

                    <div class="cart-totals-right">
                        <div>
                            Subtotal <br>
                            @if(session()->has('coupon'))
                                Code ({{ session()->get('coupon')['code'] }})
                                <form action="{{ route('coupon.destroy') }}" method="POST" style="display: block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="font-size: 14px">remove</button>
                                </form>
                                <hr>
                                New Subtotal<br>
                            @endif
                            Tax{{ Config::get('cart.tax') . '%' }} <br>
                            <span class="cart-totals-total">Total</span>
                        </div>
                        <div class="cart-totals-subtotal">
                            $ <span class="cart-subtotal">{{ formatPrice(Cart::instance('default')->subtotal()) }}</span> <br>
                            @if(session()->has('coupon'))
                                -$ <span class="cart-discount">{{ formatPrice($discount) }}</span> <br><br>
                                <hr>
                                $ <span class="cart-newSubtotal">{{ formatPrice($newSubtotal) }} </span> <br>
                            @endif
                            $ <span class="cart-newTax">{{ formatPrice($newTax) }}</span> <br>
                           $ <span class="cart-newTotal">{{ formatPrice($newTotal) }}</span>
                        </div>
                    </div>
                </div> <!-- end cart-totals -->


                <div class="cart-buttons">
                    <a href="{{route('shop.index')}}" class="button">Continue Shopping</a>
                    <a href="{{route('checkout.index')}}" class="button-primary">Proceed to Checkout</a>
                </div>

            @else
                <h3>No Items In Cart!</h3>
                <div class="spacer"></div>
                <a href="{{route('shop.index')}}" class="button">Continue Shopping</a>
                <div class="spacer"></div>
            @endif


            @if(Cart::instance('saveForLater')->count() > 0)
                <h2> {{Cart::instance('saveForLater')->count()}} item(s) Saved For Later</h2>

                <div class="saved-for-later cart-table">

                    @foreach(Cart::instance('saveForLater')->content()  as $item)
                        <div class="cart-table-row">
                            <div class="cart-table-row-left">
                                <a href="{{route('shop.show', $item->model->slug)}}">
                                    <img src="{{ productImage($item->model->image) }}" alt="item"
                                         class="cart-table-img">
                                </a>
                                <div class="cart-item-details">
                                    <div class="cart-table-item"><a href="{{route('shop.show', $item->model->slug)}}">
                                            {{$item->model->name}}
                                        </a>
                                    </div>
                                    <div class="cart-table-description">{{$item->model->details}}</div>
                                </div>
                            </div>
                            <div class="cart-table-row-right">
                                <div class="cart-table-actions">
                                    {{--                                    <a href="#">Remove</a> <br>--}}
                                    <form action="{{route('saveForLater.destroy' ,$item->rowId )}}" method="POSt">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="cart-options">Remove</button>
                                    </form>

                                    {{--                                    <a href="#">Move to Cart</a>--}}

                                    <form action="{{route('saveForLater.switchToCart' , $item->rowId)}}" method="POST">
                                        @csrf
                                        <button type="submit" class="cart-options">Move to Cart</button>
                                    </form>
                                </div>
                                {{-- <div>
                                    <select class="quantity">
                                        <option selected="">1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select>
                                </div> --}}
                                <div>{{$item->model->parsePrice()}}</div>
                            </div>
                        </div> <!-- end cart-table-row -->

                    @endforeach

                </div> <!-- end saved-for-later -->

            @else
                <h3>No Items Save For Later!</h3>
            @endif

        </div>

    </div> <!-- end cart-section -->

    @include('partials.might-like')


@endsection

@section('extra-js')

    <script src="{{asset('js/app.js')}}"></script>

    <script>

        (function () {

            const classname = document.querySelectorAll('.quantity');

            Array.from(classname).forEach((element) => {
                element.addEventListener('change', function () {
                    const id = this.getAttribute('data-id');
                    const productQuantity = this.getAttribute('data-productQuantity');

                    axios.patch('/cart/' + id, {
                        quantity: this.value,
                        productQuantity: productQuantity
                    })
                        .then(function (response) {
                            // console.log(response);
                            {{--window.location.href = '{{ route('cart.index') }}'--}}
                                //get response data
                            const data = response.data;
                            console.log(data)
                            //get all element
                            if(data.hascoupon)
                            {
                                const discount = document.querySelector('.cart-discount');
                                const newsubtoal = document.querySelector('.cart-newSubtotal');

                                //inset data
                                discount.innerHTML = '$ '+ data.discount;
                                newsubtoal.innerHTML = '$ '+ data.newSubtotal;
                            }

                            const subtotal_quantity = document.querySelector('.subtotal');
                            const subtotal = document.querySelector('.cart-subtotal');
                            const newtax = document.querySelector('.cart-newTax');
                            const newtotal = document.querySelector('.cart-newTotal');

                            //add data to element
                            subtotal_quantity.innerHTML =  data.subtotal;
                            subtotal.innerHTML =  data.subtotal;
                            newtax.innerHTML =  data.newTax;
                            newtotal.innerHTML = data.newTotal;

                            // document.location.reload(true)
                        })
                        .catch(function (error) {
                            // console.log(error);
                            window.location.href = '{{ route('cart.index') }}'
                        });

                });
            });
        })()

    </script>




    {{--    <script>--}}
    {{--        // vanilla js code for ajax --}}
    {{--        (function (){--}}
    {{--        --}}
    {{--            var selectors = document.querySelectorAll('.quantity');--}}
    {{--        --}}
    {{--            Array.from(selectors).forEach((element) => {--}}
    {{--                element.addEventListener('change' ,setQuantity);--}}
    {{--            })--}}
    {{--        --}}
    {{--                function setQuantity() {--}}
    {{--                    var xml = new XMLHttpRequest();--}}
    {{--        --}}
    {{--                    xml.onreadystatechange = function(){--}}
    {{--        --}}
    {{--                        if(xml.readyState === xml.DONE && xml.status === 200)--}}
    {{--                        {--}}
    {{--                            console.log(JSON.parse(xml.response))--}}
    {{--                        }--}}
    {{--                    }--}}
    {{--        --}}
    {{--                    xml.open('PATCH' , '/cart/' + this.id , true);--}}
    {{--                    xml.setRequestHeader('X-Requested-With', 'XMLHttpRequest');--}}
    {{--                    xml.setRequestHeader('X-CSRF-Token', '{{csrf_token()}}');--}}
    {{--                    xml.setRequestHeader("Content-type","application/x-www-form-urlencoded");--}}
    {{--                    xml.send("quantity=" + this.value);--}}
    {{--        --}}
    {{--                }--}}
    {{--        --}}
    {{--        })();--}}
    {{--    </script>--}}


    {{--    {--      agolia js fro search part--}}
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="{{ asset('js/algolia.js') }}"></script>
@endsection


