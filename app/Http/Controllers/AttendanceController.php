<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Models\User;
use App\Http\Models\Work;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('/app/attendance');
    }

    public function workIn()
    {
        $user = Auth::user();

        // 打刻は１日一回までにしたい

        $oldTimestamp = Work::where('user_id', $user->id)->latest()->first();
        if ($oldTimestamp) {
            $oldTimestampPunchIn = new Carbon($oldTimestamp->start_work);
            $oldTimestampDay = $oldTimestampPunchIn->startOfDay();
        } else {
            $timestamp = Work::create([
                'user_id' => $user->id,
                'start_work' => Carbon::now(),
            ]);

            return redirect()->back()->with('message', 'おはようございます');
        }

        $newTimestampDay = Carbon::today();

        // 日付を比較、同日の出勤打刻かつ、直前のTimestampの退勤打刻がされてない場合エラーを吐く。
        if ($oldTimestampDay == $newTimestampDay && (empty($oldTimestamp->end_work))) {
            return redirect()->back()->with('message', 'すでに出勤打刻がされています');
        }

        $timestamp = Work::create([
            'user_id' => $user->id,
            'start_work' => Carbon::now(),
        ]);

        return redirect()->back()->with('message', '出勤打刻が完了しました');
    }

    public function workOut()
    {
        $user = Auth::user();
        $timestamp = Work::where('user_id', $user->id)->latest()->first();

        if ( !empty($timestamp->end_work)) {
            return redirect()->back()->with('message', '既に退勤の打刻がされているか、出勤打刻されていません');
        }
        $timestamp->update([
            'end_work' => Carbon::now()
        ]);

        return redirect()->back()->with('message', 'お疲れ様でした。');
    }

    public function restIn()
    {
        $user = Auth::user();
        $timestamp = Work::where('user_id', $user->id)->latest()->first();

        // 出勤済み、退勤前、休憩前の場合打刻
        if ($timestamp->start_work && (empty($timestamp->end_work)) && (empty($timestamp->start_rest))) {
            $timestamp->update([
                'start_rest' => Carbon::now()
            ]);
            return redirect()->back();
        }

        return redirect()->back();

    }

    public function restOut()
    {
        $user = Auth::user();
        $timestamp = Work::where('user_id', $user->id)->latest()->first();

        // 休憩済み、退勤前の場合打刻
        if($timestamp->start_rest && (empty($timestamp->end_rest))) {
            $timestamp->update([
                'end_rest' => Carbon::now()
            ]);
            return redirect()->back();
        }
        return redirect()->back();
    }
}
