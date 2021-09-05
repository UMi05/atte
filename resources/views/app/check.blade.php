@extends('layouts.app')

@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="date py-5 h1">
                @foreach($dates as $date)
                    {{$date->attendance_date}}
                @endforeach
                {{ $dates->links() }}
            </div>
    </div>
    <div class="table-size">
        <table class="table">
            <thead align="center">
                <tr>
                    <th class="table-ttl">名前</th>
                    <th class="table-ttl">勤務開始</th>
                    <th class="table-ttl">勤務終了</th>
                    <th class="table-ttl">休憩時間</th>
                    <th class="table-ttl">勤務時間</th>
                </tr>
            </thead>
            <tbody align="center">
                @foreach($users as $user)
                    @foreach($workTs as $workT)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$workT->start_work}}</td>
                        <td>{{$workT->end_work}}</td>
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection