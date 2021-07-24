@extends('layout')

@section('title', 'Search Result Algolia')

@section('extra-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/instantsearch.css@7.4.5/themes/satellite-min.css" integrity="sha256-TehzF/2QvNKhGQrrNpoOb2Ck4iGZ1J/DI4pkd2oUsBc=" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/algolia-instant.css') }}">
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">


@endsection

@section('content')

    <x-breadcrumbs>
        <a href="{{route('landing-page')}}">Home</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>Search-Algolia</span>
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


        {{--Algolia search--}}
        <div class="left-panel">
            <h2>Search</h2>
            <div id="search-box">
                <!-- SearchBox widget will appear here -->
            </div>

            <div id="stats-container">

            </div>

            <h2>Categories</h2>
            <div id="refinement-list">
                <!-- RefinementList widget will appear here -->
            </div>

        </div>

        <div class="right-panel">
            <div id="hits">
                <!-- Hits widget will appear here -->
            </div>

            <div id="pagination">
                <!-- Pagination widget will appear here -->
            </div>
        </div>

    </div>


@endsection
@section('extra-js')
    {{-- this is instantjs not autocomplete for algolia --}}

    <script src="https://cdn.jsdelivr.net/npm/algoliasearch@4.5.1/dist/algoliasearch-lite.umd.js" integrity="sha256-EXPXz4W6pQgfYY3yTpnDa3OH8/EPn16ciVsPQ/ypsjk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/instantsearch.js@4.8.3/dist/instantsearch.production.min.js" integrity="sha256-LAGhRRdtVoD6RLo2qDQsU2mp+XVSciKRC8XPOBWmofM=" crossorigin="anonymous"></script>
    <script src="{{ asset('js/algolia-instant.js') }}"></script>


{{--    algolia autocomplete js --}}
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="{{ asset('js/algolia.js') }}"></script>
@endsection


