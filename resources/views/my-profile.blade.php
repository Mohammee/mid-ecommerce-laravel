@extends('layout')

@section('title', 'My Profile')

@section('extra-css')

    <!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">

@endsection

@section('content')

    <x-breadcrumbs>
        <a href="{{route('landing-page')}}">Home</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>My Profile</span>
    </x-breadcrumbs><!-- end breadcrumbs -->


    <div class="products-section my-profile container">
        <div class="sidebar">
            <ul>

                <li class="{{ request()->is('my-profile') ? 'active' : '' }}">
                    @if(request()->is('my-profile'))
                        <i class="fa fa-chevron-right breadcrumb-separator"></i>
                    @endif
                    <a href="{{ route('users.edit') }}">My Profile</a>
                </li>
                <li class="{{ request()->is('my-orders') ? 'active' : ''  }}">
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
                <h1 class="stylish-heading">My Porfile</h1>
            </div>

            <div>

                <form action="{{ route('users.update') }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="form-control">
                        <input type="text" id="name" name="name" placeholder="Name" value="{{ old('name' , $user->name) }}" required>
                    </div>

                    <div class="form-control">
                        <input type="email" id="email" name="email" placeholder="Email" value="{{ old('eamil' , $user->email) }}" required>
                    </div>

                    <div class="form-control">
                        <input type="password" id="password" name="password" placeholder="Password">
                        <div class="password-hint">Leave password blank to keep current password</div>
                    </div>

                    <div class="form-control">
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               placeholder="Confirm Password">
                    </div>

                    <button class="update-profile-button" type="submit">Update Profile</button>
                </form>

            </div> <!-- end profile -->
            <div class="spacer"></div>

        </div>
    </div>

@endsection


@section('extra-js')
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="{{ asset('js/algolia.js') }}"></script>

@endsection
