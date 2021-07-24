@extends('layout')
@section('title' , 'Reset Password')

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


                <h2>{{ __('Reset Password') }}</h2>
                <div class="spacer"></div>

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">


                    <input type="email" name="email" value="{{ old('email') }}"
                           required placeholder="Email" autofocus>
                    <input type="password" name="password" value="{{ old('password') }}"
                           required placeholder="Password" autofocus>
                    <input id="password-confirm" type="password"  name="password_confirmation"
                           required placeholder="Confirm Password">


                        <button type="submit" class="auth-button">
                            {{ __('Reset Password') }}
                        </button>

                </form>
            </div>

            <div class="auth-right">
                <h2>Reset Password Information</h2>
                <div class="spacer"></div>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vel dicta obcaecati exercitationem ut atque inventore
                    cum. Magni autem error ut!</p>
                <div class="spacer"></div>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Vel accusantium quasi necessitatibus rerum fugiat eos,
                    a repudiandae tempore nisi ipsa delectus sunt natus!</p>
            </div>

        </div> <!-- end auth-pages -->


    </div>

@endsection
