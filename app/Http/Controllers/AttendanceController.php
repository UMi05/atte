<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Date;
use App\Models\Work;
use App\Models\Rest;
use App\Models\Date_User;
use Carbon\Carbon;

class AttendanceController extends Controller
{


    public function workIn()
    {
        $user = Auth::user();
        $workDate = Date::latest()->first();
        $workTimestamp = Work::latest()->first();

        if (!$workDate && !$workTimestamp) {
            Date::create([
                'date' => Carbon::today()
            ]);
        }

        if ($workDate && !$workTimestamp) {
            Date_User::create([
                'user_id' => $user->id,
                'date_id' => $workDate->id
            ]);
        }

        $workTimestamp = Work::where('user_id', $user->id)->latest()->first();
        $workDate = Date::latest()->first();

        //** レコードが空の場合、出勤打刻 */
        if (!$workTimestamp) {

            $workDate = Date::latest()->first();

            Work::create([
                'user_id' => $user->id,
                'date_id' => $workDate->id,
                'start_work' => Carbon::now(),
            ]);

            Date_User::create([
                'user_id' => $user->id,
                'date_id' => $workDate->id
            ]);

            return redirect()->back()->with('message', 'おはようございます、本日もよろしくお願いします。');

        }

        /**
        * 最新のレコードの打刻確認し、打刻されていた場合
        * 打刻済みの日付取得かつ、その日の日付を取得
        */
        if ($workTimestamp) {

            $oldTimestampDay = $workDate->date;
            $todayTimestamp = Carbon::today();

        }

        //** 同日の出勤打刻の重複を防ぐ */
        if (($oldTimestampDay == $todayTimestamp) && !$workTimestamp->end_work) {

            return redirect()->back()->with('message', 'すでに出勤打刻がされています。');

        } elseif (($oldTimestampDay == $todayTimestamp) && $workTimestamp->start_work && $workTimestamp->end_work) {

            return redirect()->back()->with('message', '本日は既に業務終了しています。');

        } elseif ($oldTimestampDay !== $todayTimestamp) {

            Date::create([
                'date' => Carbon::today()
            ]);

            $workDate = Date::latest()->first();

            Work::create([
                'user_id' => $user->id,
                'date_id' => $workDate->id,
                'start_work' => Carbon::now(),
            ]);

            $workTimestamp = Work::where('user_id', $user->id)->latest()->first();

            Date_User::create([
                'user_id' => $user->id,
                'date_id' => $workDate->id
            ]);

            return redirect()->back()->with('message', 'おはようございます、本日もよろしくお願いします。');

        } else {

            return redirect()->back();

        }

    }


    public function workOut()
    {

        $user = Auth::user();
        $date_users = Date_User::where('user_id', $user->id)->latest()->first();

        /** dates tableが空（出勤記録がない）または、出勤打刻前 */
        if (!$date_users) {
            return redirect()->back()->with('message', '出勤打刻されていません。');
        }

        $workDate = Date::where('id', $date_users->date_id)->latest()->first();
        $workTimestamp = Work::where('date_id', $workDate->id)->where('user_id', $user->id)->latest()->first();
        $restTimestamp = Rest::where('work_id', $workTimestamp->id)->latest()->first();

        /**
         * 退勤打刻後、押したときの処理
         * 休憩終了打刻がされていなかった場合、退勤打刻時間と一緒に打刻
         * 退勤打刻の処理
         */

        $endTimestamp = Carbon::today();
        $latestTimestampday = Date::latest()->first();

        if ($workTimestamp->end_work) {

            return redirect()->back()->with('message', '退勤済みです。');

        }elseif ($restTimestamp && !$restTimestamp->end_rest && ($endTimestamp == $latestTimestampday)) {

            $restTimestamp->update([
                'end_rest' => Carbon::now()
            ]);

            $workTimestamp->update([
                'end_work' => Carbon::now()
            ]);
            return redirect()->back()->with('message', 'お疲れ様でした。');

        } elseif ($workTimestamp->start_work && ($endTimestamp == $latestTimestampday)) {

            $workTimestamp->update([
                'end_work' => Carbon::now()
            ]);
            return redirect()->back()->with('message', 'お疲れ様でした。');

        } elseif ($workTimestamp->start_work && ($endTimestamp !== $latestTimestampday)) {

            Date::create([
                'date' => Carbon::today()
            ]);

            $workDate = Date::latest()->first();

            Work::create([
                'user_id' => $user->id,
                'date_id' => $workDate->id,
                'start_work' => Carbon::now(),
            ]);

            $workTimestamp = Work::where('user_id', $user->id)->latest()->first();

            Date_User::create([
                'user_id' => $user->id,
                'date_id' => $workDate->id
            ]);

            return redirect()->back()->with('message', '日を跨いだため出勤打刻をします。');

        }

    }


    public function restIn()
    {
        $user = Auth::user();
        $date_users = Date_User::where('user_id', $user->id)->latest()->first();

        //** 出勤前（dates teble が空の場合のエラー防止） */
        if (!$date_users) {
            return redirect()->back()->with('message', '出勤打刻されていません。');
        }

        $workDate = Date::where('id', $date_users->date_id)->latest()->first();
        $workTimestamp = Work::where('date_id', $workDate->id)->latest()->first();

        $restTimestamp = Rest::latest()->first();

        /**
        * 出勤打刻後かつ、restテーブルがからの場合
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
        $date_users = Date_User::where('user_id', $user->id)->latest()->first();

        //** 出勤前（dates table が空の場合のエラー防止） */
        if (!$date_users) {
            return redirect()->back()->with('message', '出勤打刻されていません。');
        }

        $workDate = Date::where('id', $date_users->date_id)->latest()->first();
        $workTimestamp = Work::where('date_id', $workDate->id)->latest()->first();

        $restTimestamp = Rest::where('work_id', $workTimestamp->id)->latest()->first();

        /**
        * 休憩のレコードがない場合
        * 休憩終了の処理
        * 退勤打刻後、押した場合の処理
        * 休憩開始前で押したときの処理
        */
        if(!$restTimestamp) {

            return redirect()->back()->with('message', '休憩履歴がありません');

        } elseif ($restTimestamp->start_rest && !$restTimestamp->end_rest) {

            $restTimestamp->update([
                'end_rest' => Carbon::now()
            ]);
            return redirect()->back()->with('message', '休憩終了です、引き続きよろしくお願いします。');

        } elseif (!$restTimestamp->rest_start && ($workTimestamp->start_work && !$workTimestamp->end_work)) {

            return redirect()->back()->with('message', '休憩開始されていません。');

        } elseif ($workTimestamp->end_work) {

            return redirect()->back()->with('message', '退勤済みです。');

        } else {

            return redirect()->back();
        }
    }
}