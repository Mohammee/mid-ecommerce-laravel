@extends('layout')

@section('title', $product->name)

@section('extra-css')
    <!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection

@section('content')

    <x-breadcrumbs>
        <a href="{{route('landing-page')}}">Home</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <a href="{{route('shop.index')}}"><span>Shop</span></a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>{{$product->name}}</span>
    </x-breadcrumbs><!-- end breadcrumbs -->

    <div class="container">
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
    </div>

    <div class="product-section container">
        <div>
            <div class="product-section-image">
                <img src="{{ productImage($product->image) }}" alt="product" class="active" id="currentImage">
            </div>

            <div class="product-section-images">


                <div class="product-section-thumbnail selected">
                    <img src="{{ productImage($product->image) }}" alt="product_image">
                </div>

                {{--                multi images--}}
                @if($product->images)
                    @foreach( (json_decode($product->images , true)) as $image)

                        <div class="product-section-thumbnail selected">
                            <img src="{{ productImage($image) }}" alt="product_image">
                        </div>

                    @endforeach
                @endif

            </div>

        </div>

        <div class="product-section-information">
            <h1 class="product-section-title">{{$product->name}}</h1>
            <div class="product-section-subtitle">{{$product->details}}</div>

            {!! $stockLevel !!}

            <div class="product-section-price">${{$product->parsePrice()}}</div>

            <p>
                {!! $product->description !!}
            </p>

            <p>&nbsp;</p>

            @if($product->quantity > 0)

            <form action="{{route('cart.store' , $product)}}" method="post">

                {{csrf_field()}}
                <button type="submit" class="button button-palin">Add to Cart</button>

            </form>

            @endif

        </div>


    </div> <!-- end product-section -->




    @include('partials.might-like')


@endsection

@section('extra-js')

    <script>


        (function () {

            const currentImage = document.querySelector('#currentImage');
            const images = document.querySelectorAll('.product-section-thumbnail');

            images.forEach((image) => image.addEventListener('click', thumbnailClick));

            function thumbnailClick(e) {
                // currentImage.src = this.querySelector('img').src;
                currentImage.classList.remove('active');

                currentImage.addEventListener('transitionend', () => {
                    currentImage.src = this.querySelector('img').src;
                    currentImage.classList.add('active');
                })

                images.forEach((image) => image.classList.remove('selected'))
                this.classList.add('selected');
            }

        })();
    </script>


    {{--    {--      agolia js fro search part--}}
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="{{ asset('js/algolia.js') }}"></script>

@endsection
