@extends('layout')

@section('title', 'My Orders')

@section('extra-css')

    <!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">

@endsection

@section('content')

    <x-breadcrumbs>
        <a href="{{route('landing-page')}}">Home</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>My Orders</span>
    </x-breadcrumbs><!-- end breadcrumbs -->


    <div class="products-section my-orders container">
        <div class="sidebar">
            <ul>
                <li class="{{ request()->is('my-profile') ? 'active' : '' }}">
                    @if(request()->is('my-profile'))
                    <i class="fa fa-chevron-right breadcrumb-separator"></i>
                    @endif
                    <a href="{{ route('users.edit') }}">My Profile</a>
                </li>
                <li class="{{ request()->is('my-orders') ? 'active' : '' }}">
                    @if(request()->is('my-orders'))
                        <i class="fa fa-chevron-right breadcrumb-separator"></i>
                    @endif
                    <a href="{{ route('orders.index') }}">My Orders</a>
                </li>

            </ul>

        </div> <!-- end sidebar -->
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

            <div class="products-header">
                <h1 class="stylish-heading">My Orders</h1>
            </div>

            <div>

                @forelse($orders as $order)
                    <div class="orders-container">
                        <div class="orders-header">
                            <div class="order-header-item">
                                <div>
                                    <div class="uppercase font-bold">Order Placed</div>
                                    <div>{{ presentDate($order->created_at) }}</div>
                                </div>
                                <div>
                                    <div class="uppercase font-bold">Order ID</div>
                                    <div>{{ $order->id }}</div>
                                </div>
                                <div>
                                    <div class="uppercase font-bold">Total</div>
                                    <div>$ {{ formatPrice($order->billing_total) }}</div>
                                </div>
                            </div>
                            <div><a href="{{ route('order.show' , $order->id) }}">Order Details</a> | <a href="#">Invoice</a></div>
                        </div>


                        <div class="orders-products">

                            @foreach($order->products as $product)

                                <div class="order-product-item">
                                    <div><img src="{{ productImage($product->image) }}" alt="Product Image"></div>
                                    <div>
                                        <div>
                                            <a href="{{ route('shop.show' , $product->slug) }}"> {{ $product->name }} </a>
                                        </div>
                                        <div> ${{ $product->parsePrice() }}</div>
                                        <div>Quantity: {{ $product->pivot->quantity }}</div>
                                    </div>
                                </div>

                                @if(!$loop->last)
                                    <hr>
                                @endif
                            @endforeach
                        </div>

                    </div>

                @empty
                    <div>You don't have any order.</div>
                @endforelse

            </div> <!-- end orders -->
            <div class="spacer"></div>

        </div>
    </div>

@endsection


@section('extra-js')
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="{{ asset('js/algolia.js') }}"></script>

@endsection
