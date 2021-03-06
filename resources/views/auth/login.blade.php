@extends('layout')
@section('title' , 'Login')

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


                <h2>Returning Customer</h2>
                <div class="spacer"></div>

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <input type="email" name="email" value="{{ old('email') }}"
                           required placeholder="Email" autofocus>
                    <input type="password" name="password" value="{{ old('password') }}"
                           required placeholder="Password" autofocus>

                    <div class="login-container">

                        <button  class="auth-button" type="submit">Login</button>

                        <label>
                            <input type="checkbox" name="remember"
                                   id="remember" {{ old('remember') ? 'checked' : '' }}>
                            {{ __('Remember Me') }}
                        </label>

                    </div>

                    <div class="spacer"></div>

                    @if (Route::has('password.request'))
                        <a class="" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif

                </form>
            </div>

            <div class="auth-right">

                <h2>New Customer</h2>
                <div class="spacer"></div>
                @if(redirect()->intended()->getTargetUrl() == route('checkout.index'))
                    <p><strong>Save time now.</strong></p>
                    <p>You don't need an account to checkout.</p>
                    <div class="spacer"></div>
                    <a href="{{ route('guestCheckout.index') }}" class="auth-button-hollow">
                        Continue as Guest
                    </a>
                    <div class="spacer"></div>
                    &nbsp
                    <div class="spacer"></div>
                @endif



                <p><strong>Save for later.</strong></p>
                <p>Create an acount for fast checkout and easy access to order history .</p>
                <div class="spacer"></div>
                <a href="{{ route('register') }}" class="auth-button-hollow">
                    Create Account
                </a>

            </div>

        </div>
    </div>

@endsection
