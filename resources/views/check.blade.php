@extends('layouts.app')

@section('content')
<div class="container">
    {{ $date_users->links() }}
    <div class="row justify-content-center">
        <div class="date">
            @foreach($date_users as $date)
                <h1>{{ $date->date->date->format('Y-m-d') }}</h1>
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
                    <th class="table-ttl">休憩時間</th>
                    <th class="table-ttl">勤務時間</th>
                </tr>
            </thead>
            <tbody align="center">
                @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->user->name }}</td>
                            <td>{{ $user->start_work }}</td>
                            <td>{{ $user->end_work }}</td>
                        </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
@endsection