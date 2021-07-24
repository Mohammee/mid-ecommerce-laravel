@extends('layout')

@section('title', 'My Order')

@section('extra-css')

    <!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">

@endsection

@section('content')

    <x-breadcrumbs>
        <a href="{{route('landing-page')}}">Home</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>My Order</span>
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
                <h1 class="stylish-heading">Order ID: {{ $order->id }}</h1>
            </div>

            <div>
                <!-- Order Details -->
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
                        <div><a href="#">Invoice</a></div>
                    </div>


                    <div class="orders-products">

                        <table class="table" style="width: 50%">
                            <tbody>

                            <tr>
                                <td>Name</td>
                                <td>{{ $order->user->name }}</td>
                            </tr>

                            <tr>
                                <td>Address</td>
                                <td>{{ $order->billing_address }}</td>
                            </tr>

                            <tr>
                                <td>City</td>
                                <td>{{ $order->billing_city }}</td>
                            </tr>

                            <tr>
                                <td>Subtotal</td>
                                <td>${{ formatPrice($order->billing_subtotal) }}</td>
                            </tr>

                            <tr>
                                <td>Tax</td>
                                <td>${{ formatPrice($order->billing_tax) }}</td>
                            </tr>

                            <tr>
                                <td>Total</td>
                                <td>${{ formatPrice($order->billing_total) }}</td>
                            </tr>

                            </tbody>
                        </table>
                    </div>

                </div>


                <!-- Order Items -->
                <div class="orders-container">
                    <div class="orders-header">
                        <div class="order-header-item">
                            <div>Order Items</div>
                        </div>
                    </div>

                    <div class="orders-products">

                        @foreach($products as $product)

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
