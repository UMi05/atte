@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div>
                <div class="text-center mb-5">
                    <h1 class="display-8 font-weight-normal">{{ __('Login') }}</h1>
                </div>
                <div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="d-flex justify-content-center form-group row">
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="メールアドレス">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-center form-group row">
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="パスワード">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mt-4 w-full">
                            <div class="col-md-6 offset-md-3">
                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ __('Login') }}
                                </button><br>

                                <p class="d-flex justify-content-center" style="color: gray;">アカウントをお持ちで無い方はこちら</p>

                                <a class="d-flex justify-content-center" href="{{ route('register') }}">
                                    {{ __('Register') }}
                                </a><br>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link d-flex justify-content-center" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
