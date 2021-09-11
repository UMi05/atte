<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Work;
use App\Models\Rest;
use Carbon\Carbon;


class AttendanceController extends Controller
{


    public function workIn()
    {
        $user = Auth::user();
        $workTimestamp = Work::where('user_id', $user->id)->latest()->first();

        //** レコードが空の場合、出勤打刻 */
        if (!$workTimestamp) {

            Work::create([
                'user_id' => $user->id,
                'start_work' => Carbon::now(),
                'attendance_date' => Carbon::today(),
            ]);
            return redirect()->back()->with('message', 'おはようございます、本日もよろしくお願いします。');

        }

        /**
        * 最新のレコードの打刻確認し、打刻されていた場合
        * 打刻済みの日付取得かつ、その日の日付を取得
        */
        if ($workTimestamp) {

            $oldTimestampDay = new Carbon($workTimestamp->attendance_date);
            $newTimestampDay = Carbon::today();

        }

        //** 同日の出勤打刻の重複を防ぐ */
        if (($oldTimestampDay == $newTimestampDay) && !$workTimestamp->end_work) {

            return redirect()->back()->with('message', 'すでに出勤打刻がされています。');

        } elseif (($oldTimestampDay == $newTimestampDay) && $workTimestamp->start_work && $workTimestamp->end_work) {

            return redirect()->back()->with('message', '本日は既に業務終了しています。');

        } elseif (($oldTimestampDay !== $newTimestampDay) && !$workTimestamp->end_work) {

            $workTimestamp->update([
                'end_work' => new Carbon('23:00:00')
            ]);

            Work::create([
                'user_id' => $user->id,
                'start_work' => Carbon::now(),
                'attendance_date' => Carbon::today(),
            ]);
            return redirect()->back()->with('message', 'おはようございます、本日もよろしくお願いします。');

        } elseif (($oldTimestampDay !== $newTimestampDay)) {

            Work::create([
                'user_id' => $user->id,
                'start_work' => Carbon::now(),
                'attendance_date' => Carbon::today(),
            ]);
            return redirect()->back()->with('message', 'おはようございます、本日もよろしくお願いします。');

        } else {

            return redirect()->back();

        }

    }


    public function workOut()
    {
        $user = Auth::user();
        $workTimestamp = Work::where('user_id', $user->id)->latest()->first();
        $restTimestamp = Rest::where('work_id', $workTimestamp->id)->latest()->first();

        /**
         * work テーブルが空（出勤記録がない）または、出勤打刻前
         * 退勤打刻後、押したときの処理
         * 休憩終了打刻がされていなかった場合、退勤打刻時間と一緒に打刻
         * 退勤打刻の処理
         */
        if (!$workTimestamp || !$workTimestamp->start_work) {

            return redirect()->back()->with('message', '出勤打刻されていません。');

        } elseif ($workTimestamp->end_work) {

            return redirect()->back()->with('message', '退勤済みです。');

        }elseif ($restTimestamp && !$restTimestamp->end_rest) {

            $restTimestamp->update([
                'end_rest' => Carbon::now()
            ]);

            $workTimestamp->update([
                'end_work' => Carbon::now()
            ]);
            return redirect()->back()->with('message', 'お疲れ様でした。');

        } elseif ($workTimestamp->start_work) {

            $workTimestamp->update([
                'end_work' => Carbon::now()
            ]);
            return redirect()->back()->with('message', 'お疲れ様でした。');

        }

    }


    public function restIn()
    {
        $user = Auth::user();
        $workTimestamp = work::where('user_id', $user->id)->latest()->first();

        //** 出勤前（works table が空の場合のエラー防止） */
        if (!$workTimestamp) {

            return redirect()->back()->with('message', '出勤打刻されていません。');

        } else {
            $restTimestamp = Rest::where('work_id', $workTimestamp->id)->latest()->first();
        }

        /**
        * 出勤打刻後かつ、work テーブルがからの場合
        * 休憩終了打刻前の、休憩開始打刻の重複を防ぐ
        * 既に、休憩済みでも何度も休憩可能にする処理
        * 退勤打刻後、押した場合の処理
        */

        if (($workTimestamp->start_work && !$workTimestamp->end_work) && !$restTimestamp) {

            $restTimestamp = Rest::create([
                'work_id' => $workTimestamp->id,
                'start_rest' => Carbon::now(),
            ]);
            return redirect()->back()->with('message', '休憩開始です、お疲れ様です。');

        } elseif (($workTimestamp->start_work && !$workTimestamp->end_work) && ($restTimestamp->start_rest && !$restTimestamp->end_rest)) {

            return redirect()->back()->with('message', '休憩中です。');

        } elseif(($workTimestamp->start_work && !$workTimestamp->end_work) && $restTimestamp) {

            $restTimestamp = Rest::create([
                'work_id' => $workTimestamp->id,
                'start_rest' => Carbon::now(),
            ]);
            return redirect()->back()->with('message', '休憩開始です、お疲れ様です。');

        } elseif ($workTimestamp->end_work) {

            return redirect()->back()->with('message', '退勤済みです。');

        }

    }


    public function restOut()
    {
        $user = Auth::user();
        $workTimestamp = work::where('user_id', $user->id)->latest()->first();

        //** 出勤前（works table が空の場合のエラー防止） */
        if (!$workTimestamp) {
            return redirect()->back()->with('message', '出勤打刻されていません。');
        } else {
            $restTimestamp = Rest::where('work_id', $workTimestamp->id)->latest()->first();
        }

        /**
        * 休憩のレコードがない場合
        * 休憩終了の処理
        * 退勤打刻後、押した場合の処理
        * 休憩開始前で押したときの処理
        */
        if(!$restTimestamp) {

            return redirect()->back()->with('message', '休憩開始されていません。');

        } elseif ($restTimestamp->start_rest && !$restTimestamp->end_rest) {

            $restTimestamp->update([
                'end_rest' => Carbon::now()
            ]);
            return redirect()->back()->with('message', '休憩終了です、引き続きよろしくお願いします。');

        } elseif ($workTimestamp->end_work) {

            return redirect()->back()->with('message', '退勤済みです。');

        } elseif (!$restTimestamp->rest_start) {

            return redirect()->back()->with('message', '休憩開始されていません。');

        } else {

            return redirect()->back();

        }
    }
}
