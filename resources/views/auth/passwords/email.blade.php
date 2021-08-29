@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div>
                <div class="text-center mb-5">
                    <h1>{{ __('Reset Password') }}</h1>
                </div>

                <div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
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

                        <div class="form-group row mt-4 w-full">
                            <div class="col-md-6 offset-md-3">
                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ __('Send Password Reset Link') }}
                                </button><br>
                            </div>
                        </div>
                        <a class="d-flex justify-content-center" href="{{ route('login') }}">{{ __('Login')}}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
