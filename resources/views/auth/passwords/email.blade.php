@extends('layout')
@section('title' , 'Reset Password')

@section('content')
    <div class="container">

        <div class="auth-pages">

            <div class="auth-left">

                @if(session('status'))
                    <div class="alert alert-success">
                        {{session()->get('status')}}
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


                <h2>Forgot Password!</h2>
                <div class="spacer"></div>

                <form action="{{ route('password.email') }}" method="POST">
                    @csrf

                    <input type="email" name="email" value="{{ old('email') }}"
                           required placeholder="Email" autofocus>


                    <button type="submit" class="auth-button">
                        {{ __('Send Password Reset Link') }}
                    </button>

                </form>
            </div>

            <div class="auth-right">
                <h2>Forgotten Password Information</h2>
                <div class="spacer"></div>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vel dicta obcaecati exercitationem ut atque inventore cum. Magni autem error ut!</p>
                <div class="spacer"></div>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Vel accusantium quasi necessitatibus rerum fugiat eos, a repudiandae tempore nisi ipsa delectus sunt natus!</p>
            </div>

        </div> <!-- end auth-pages -->


    </div>


@endsection
