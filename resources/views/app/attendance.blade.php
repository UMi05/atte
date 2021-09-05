@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="greeting py-5 h1">
            {{ Auth::user()->name }}さん
            @if(Session::has('message'))
                <p>{{ session('message') }}</p>
            @endif
        </div>
    </div>
    <div class="atte-btn row justify-content-center">
        <div>
            <form action="/workin" method="POST">
                @csrf
                <button type="submit" id="btn1" onclick="workin()">出勤</button>
            </form>

            <form action="/restin" method="POST">
                @csrf
                <button type="submit" id="btn3" onclick="restin()" disabled>休憩開始</button>
            </form>
        </div>

        <div>
            <form action="/workout" method="POST">
                @csrf
                <button type="submit" id="btn2" onclick="workout()" disabled>退勤</button>
            </form>

            <form action="/restout" method="POST">
                @csrf
                <button type="submit" id="btn4" onclick="restout()" disabled>休憩終了</button>
            </form>
        </div>

    </div>
</div>
@endsection
