@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="greeting py-5">
            <h1>{{ Auth::user()->name }}さん</h1>
            @if (session('message'))
                {{ session('message') }}
            @endif
        </div>
    </div>
    <div class="atte-btn row justify-content-center">
        <div>
            <form action="{{ route('workin') }}" method="POST">
                @csrf
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <button type="submit" id="btn1" onclick="workin()" name="workIn" value="workIn">出勤</button>
            </form>

            <form action="{{ route('restin') }}" method="POST">
                @csrf
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <button type="submit" id="btn3" onclick="restin()" disabled name="restIn" value="restIn">休憩開始</button>
            </form>
        </div>

        <div>
            <form action="{{ route('workout') }}" method="POST">
                @csrf
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <button type="submit" id="btn2" onclick="workout()" disabled name="workOut" value="workOut">退勤</button>
            </form>

            <form action="{{ route('restout') }}" method="POST">
                @csrf
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <button type="submit" id="btn4" onclick="restout()" disabled name="restOut" value="restOut">休憩終了</button>
            </form>
        </div>

    </div>
</div>
@endsection
