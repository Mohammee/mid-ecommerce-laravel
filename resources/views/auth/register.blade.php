@extends('layout')
@section('title' , 'Register')
@section('content')
    <div class="container">

        <div class="auth-pages">

            <div class="auth-left">

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


                <h2>Create Account</h2>
                <div class="spacer"></div>

                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <input id="name" type="text" name="name" value="{{ old('name') }}"
                           required placeholder="Name" autofocus>
                    <input type="email" name="email" value="{{ old('email') }}"
                           required placeholder="Email" autofocus>
                    <input type="password" name="password" value="{{ old('password') }}"
                           required placeholder="Password" autofocus>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                           required placeholder="Confirm Password">


                    <div class="login-container">
                        <button type="submit" class="auth-button">Create Account</button>
                        <div class="already-have-container">
                            <p><strong>Already have an account?</strong></p>
                            <a href="{{ route('login') }}">Login</a>
                        </div>
                    </div>

                </form>
            </div>

            <div class="auth-right">
                <h2>New Customer</h2>
                <div class="spacer"></div>
                <p><strong>Save time now.</strong></p>
                <p>Creating an account will allow you to checkout faster in the future, have easy access to order history and customize your experience to suit your preferences.</p>

                &nbsp;
                <div class="spacer"></div>
                <p><strong>Loyalty Program</strong></p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt debitis, amet magnam accusamus nisi distinctio eveniet ullam. Facere, cumque architecto.</p>
            </div>

        </div> <!-- end auth-pages -->


    </div>

@endsection
