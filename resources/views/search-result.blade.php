@extends('layout')

@section('title', 'Search')

@section('extra-css')

    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection

@section('content')

    <x-breadcrumbs>
        <a href="{{route('landing-page')}}">Home</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>Search</span>
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

    <div class="search-results-container container">

        <h1>Search Result</h1>
        <div class="spacer"></div>

        <p class="search-results-count">{{ $products->total() }} product(s) for "{{ request()->input('query') }}"</p>
        <div class="spacer"></div>

        @if($products->count() > 0)
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Details</th>
                    <th scope="col">Describe</th>
                    <th scope="col">Featured</th>
                    <th scope="col">Price($)</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)

                    <tr class="{{ $product->featured ? 'table-info' : '' }}">
                        <th> <a href="{{ route('shop.show' , $product->slug) }}">
                      {{ $product->name }}
                        </a></th>
                        <td>{{ $product->details }}</td>
                        <td>{{ Str::limit($product->description , 80)}}</td>
                        <td>{{ $product->featured ? 'yes' : 'no' }}</td>
                        <td>${{ $product->parsePrice() }}</td>
                    </tr>

                @endforeach
                </tbody>
            </table>

            <div class="spacer"></div>

            <div class="pagination-center">
                {{ $products->withQueryString()->links('pagination::bootstrap-4') }}
            </div>

        @else
            <p>No products to display!!</p>
        @endif

    </div> <!-- end search container -->


    <div class="spacer"></div>
@endsection

@section('extra-js')
{{--    <script src="{{asset('js/app.js')}}"></script>--}}

{{--    <script>--}}
{{--    (function(){--}}

{{--        const search = document.querySelector('#query');--}}
{{--        search.onkeyup = function () {--}}

{{--            axios.get('/search', {--}}
{{--                params: {--}}
{{--                    query:this.value--}}
{{--                }--}}
{{--            })--}}
{{--                .then(function (response) {--}}
{{--                    console.log(response);--}}
{{--                    window.location.href = '/search' + '?query=' + response.data.query;--}}
{{--                })--}}
{{--                .catch(function (error) {--}}
{{--                    console.log(error);--}}
{{--                })--}}
{{--                .then(function () {--}}
{{--                    // always executed--}}
{{--                });--}}
{{--        }--}}
{{--    })()--}}
{{--</script>--}}


{{--    {--      agolia js fro search part--}}
<script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
<script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
<script src="{{ asset('js/algolia.js') }}"></script>
@endsection
