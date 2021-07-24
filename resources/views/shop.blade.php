@extends('layout')

@section('title', 'Shop')

@section('extra-css')

    <!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">


@endsection

@section('content')

    <x-breadcrumbs>
        <a href="{{route('landing-page')}}">Home</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>Shop</span>
    </x-breadcrumbs>

     <!-- end breadcrumbs -->

    <div class="products-section container">
        <div class="sidebar">
            <h3>By Category</h3>
            <ul>

                @foreach($categories as $category)

                    <li  class="{{ setActiveCategory($category) }}">
                        <a href="{{ route('shop.index' , ['category' => $category->slug]) }}">{{ $category->name }}</a>
                    </li>

                @endforeach

            </ul>

            {{--            <h3>By Price</h3>--}}
            {{--            <ul>--}}
            {{--                <li><a href="#">$0 - $700</a></li>--}}
            {{--                <li><a href="#">$700 - $2500</a></li>--}}
            {{--                <li><a href="#">$2500+</a></li>--}}
            {{--            </ul>--}}

        </div> <!-- end sidebar -->
        <div>

            <div class="products-header">
                <h1 class="stylish-heading">{{$categoryName}}</h1>

                @if( $products->isNotEmpty() )

                    <div>
                        <strong>Price: </strong>
                        <a href="{{ route('shop.index' , [ 'category' => request()->category , 'sort' => 'low_high']) }}">Low
                            to High</a> |
                        <a href="{{ route('shop.index' , [  'category' => request()->category ,'sort' => 'high_low']) }}">High
                            to low</a>
                    </div>

                @endif
            </div>

            <div class="products text-center">
                @forelse($products as $product)
                    <div class="product">
                        <a href="{{route('shop.show' , $product->slug)}}"><img
                                src=" {{ productImage($product->image) }}" alt="{{$product->name}}"></a>
                        <a href="{{route('shop.show' , $product->slug)}}">
                            <div class="product-name">{{$product->name}}</div>
                        </a>
                        <div class="product-price">${{$product->parsePrice()}}</div>
                    </div>
                @empty
                    <div style="text-align: left ;">No items found !!</div>
                @endforelse

            </div> <!-- end products -->
            <div class="spacer"></div>

            <div class="pagination-center">
{{--                {{ $products->links('pagination::bootstrap-4') }}--}}
                     {{ $products->appends(request()->input())->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

@endsection


@section('extra-js')
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="{{ asset('js/algolia.js') }}"></script>

@endsection
