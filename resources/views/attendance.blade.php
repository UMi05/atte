@extends('layouts.app')

@section('content')
<div class="container">
    <div class="name row justify-content-center py-3">
        <h1>{{ Auth::user()->name }}さん</h1>
    </div>
    <div class="msg row justify-content-center py-2">
        <p>{{ session('message') }}</p>
    </div>
    <div class="atte-btn row justify-content-center">
        <div>
            <form action="{{ route('workin') }}" method="POST">
                @csrf
                <button type="submit" id="btn1">出勤</button>
            </form>

            <form action="{{ route('restin') }}" method="POST">
                @csrf
                <button type="submit" id="btn3">休憩開始</button>
            </form>
        </div>

        <div>
            <form action="{{ route('workout') }}" method="POST">
                @csrf
                <button type="submit" id="btn2">退勤</button>
            </form>

            <form action="{{ route('restout') }}" method="POST">
                @csrf
                <button type="submit" id="btn4">休憩終了</button>
            </form>
        </div>

    </div>
</div>
@endsection
