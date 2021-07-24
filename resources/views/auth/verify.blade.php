@extends('layout')

@section('content')
    <div class="container">

        <div class="auth-pages">

            <div class="auth-left">

                @if (session('resent'))
                    <div class="alert alert-success">
                        {{ __('A fresh verification link has been sent to your email address.') }}
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


                <h2>{{ __('Verify Your Email Address') }}</h2>
                <div class="spacer"></div>

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form  method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="auth-button">{{ __('click here to request another') }}</button>.
                    </form>
            </div>

            <div class="auth-right">
                <h2>Verify Email Information</h2>
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
