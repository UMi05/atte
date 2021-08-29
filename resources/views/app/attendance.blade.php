@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="greeting py-5 h1">
            {{ Auth::user()->name }}さん お疲れ様です !
        </div>
    </div>
    <div class="atte-btn row justify-content-center">
        <div>
            <form class="timestamp" action="/app/attendance" >
                @csrf
                <button id="btn1" class="btn btn1" onclick="workin()">出勤</button>
            </form>

            <form class="timestamp" action="/app/attendance" >
                @csrf
                <button class="btn3" id="btn3" onclick="breakin()" disabled>休憩開始</button>
            </form>
        </div>

        <div>
            <form class="timestamp" action="/app/attendance" >
                @csrf
                <button id="btn2" class="btn2" onclick="workout()" disabled>退勤</button>
            </form>

            <form class="timestamp" action="/app/attendance" >
                @csrf
                <button class="btn4" id="btn4" onclick="breakout()" disabled>休憩終了</button>
            </form>
        </div>

    </div>
</div>
@endsection
