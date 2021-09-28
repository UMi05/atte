@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="date-line">
        {{ $allDate->links() }}
            @foreach($allDate as $date)
                <h1 class="date">{{ $date->date }}</h1>
            @endforeach
        </div>
    </div>
    <div class="table-size">
        <table class="table">
            <thead align="center">
                <tr>
                    <th class="table-ttl">名前</th>
                    <th class="table-ttl">勤務開始</th>
                    <th class="table-ttl">勤務終了</th>
                    <th class="table-ttl">休憩時間(m)</th>
                    <th class="table-ttl">勤務時間(h)</th>
                </tr>
            </thead>
            <tbody align="center">
                @foreach ($users as $user)
                    <tr>
                        <td class="table-item">{{ $user->name }}</td>
                        <td class="table-item">{{ $user->start_work }}</td>
                        <td class="table-item">{{ $user->end_work }}</td>
                        <td class="table-item">{{ $user->total_rest }}</td>
                        <td class="table-item">{{ $user->work_time }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="userPage">{{ $users->appends(request()->input())->links() }}</div>
</div>
@endsection