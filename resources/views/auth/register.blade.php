@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div>
                <div class="d-flex justify-content-center mb-5 h1">{{ __('Register') }}</div>

                <div>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="d-flex justify-content-center form-group row">
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="お名前">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-center form-group row">
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="メールアドレス">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-center form-group row">
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="パスワード">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-center form-group row">
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="確認用パスワード">
                            </div>
                        </div>

                        <div class="form-group row mt-4 w-full">
                            <div class="col-md-6 offset-md-3">
                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ __('Login') }}
                                </button><br>
                            </div>
                        </div>
                        <p class="d-flex justify-content-center mt-3" style="color: gray;">アカウントをお持ちの方はこちら</p>

                            <a class="d-flex justify-content-center" href="{{ route('login') }}">
                                {{ __('Login') }}
                            </a><br>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
