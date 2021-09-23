<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Date;
use App\Models\Work;
use App\Models\Rest;
use Carbon\Carbon;

class AttendanceController extends Controller
{


    public function workIn()
    {

        $user = Auth::user();
        $dateStamp = Date::latest()->first();

        if (!$dateStamp) {

            Date::create([
                'date' => Carbon::today()
            ]);
            $dateStamp = Date::latest()->first();

            Work::create([
                'user_id' => $user->id,
                'date_id' => $dateStamp->id,
                'start_work' => Carbon::now(),
                'attendance_date'=> Carbon::now()
            ]);

            return redirect()->back()->with('message', 'おはようございます、本日はよろしくお願いします。');

        } else {

            $todayTimestamp = Carbon::today();
            $latestDate = new Carbon($dateStamp->date);
            $workTimestamp = Work::where('user_id', $user->id)->latest()->first();

            if ($todayTimestamp == $latestDate) {

                if (!$workTimestamp) {

                    Work::create([
                        'user_id' => $user->id,
                        'date_id' => $dateStamp->id,
                        'start_work' => Carbon::now(),
                        'attendance_date'=> Carbon::now()
                    ]);

                    return redirect()->back()->with('message', 'おはようございます、本日もよろしくお願いします。');

                } elseif (!$workTimestamp->end_work) {

                    return redirect()->back()->with('message', '出勤済みです');

                } elseif ($workTimestamp->end_work) {

                    return redirect()->back()->with('message', '本日の業務は終了しています。');

                }

            } elseif (($todayTimestamp != $latestDate)) {

                    Date::create([
                        'date' => Carbon::today()
                    ]);
                    $dateStamp = Date::latest()->first();

                    Work::create([
                        'user_id' => $user->id,
                        'date_id' => $dateStamp->id,
                        'start_work' => Carbon::now(),
                        'attendance_date'=> Carbon::now()
                    ]);

                    return redirect()->back()->with('message', 'おはようございます、本日もよろしくお願いします。');

            }
        }
    }


    public function workOut()
    {

        $user = Auth::user();
        $workTimestamp = Work::where('user_id', $user->id)->latest()->first();

        /** dates tableが空（出勤記録がない）または、出勤打刻前 */
        if (!$workTimestamp) {
            return redirect()->back()->with('message', '出勤打刻されていません。');
        }

        $dateStamp = Date::latest()->first();
        $workTimestamp = Work::where('date_id', $dateStamp->id)->where('user_id', $user->id)->latest()->first();
        $restTimestamp = Rest::where('work_id', $workTimestamp->id)->latest()->first();
        $start_work = new Carbon($workTimestamp->start_work);

        $todayTimestamp = Carbon::today();
        $latestDate = new Carbon($dateStamp->date);

        if ($workTimestamp->end_work && ($latestDate == $todayTimestamp)) {

            return redirect()->back()->with('message', '退勤済みです。');

        }elseif ($restTimestamp && !$restTimestamp->end_rest && ($latestDate == $todayTimestamp)) {

            $restTimestamp->update([
                'end_rest' => Carbon::now()
            ]);

            $workTimestamp->update([
                'end_work' => Carbon::now()
            ]);

            $restTimestamp = Rest::where('work_id', $workTimestamp->id)->latest()->first();
            $start_rest = new Carbon($restTimestamp->start_rest);
            $end_rest = new Carbon($restTimestamp->end_rest);
            $rest_time = $start_rest->diffInMinutes($end_rest);

            $restTimestamp->update([
                'rest_time' => $rest_time
            ]);

            $rest_time_total = Rest::where('work_id', $workTimestamp->id)->sum('rest_time');
            $workTimestamp->update([
                'total_rest' => $rest_time_total
            ]);

            $workTimestamp = Work::where('date_id', $dateStamp->id)->where('user_id', $user->id)->latest()->first();

            $end_work = new carbon($workTimestamp->end_work);
            $work_time = $start_work->diffInMinutes($end_work);

            $rest_time = $rest_time_total;
            $working_min = $work_time - $rest_time;
            $workingHour = round(($working_min / 10) * 0.166, 3);

            $workTimestamp->update([
                'work_time' => $workingHour
            ]);

            return redirect()->back()->with('message', 'お疲れ様でした。');

        } elseif ($workTimestamp->start_work && !$workTimestamp->end_work && ($latestDate == $todayTimestamp)) {

            $workTimestamp->update([
                'end_work' => Carbon::now()
            ]);

            $workTimestamp = Work::where('date_id', $dateStamp->id)->where('user_id', $user->id)->latest()->first();

            $end_work = new carbon($workTimestamp->end_work);
            $work_time = $start_work->diffInMinutes($end_work);

            if ($restTimestamp) {

                $rest_time_total = Rest::where('work_id', $workTimestamp->id)->sum('rest_time');
                $workTimestamp->update([
                    'total_rest' => $rest_time_total
                ]);
                $rest_time = $rest_time_total;
                $working_min = $work_time - $rest_time_total;
                $workingHour = round(($working_min / 10) * 0.166, 3);

                $workTimestamp->update([
                    'work_time' => $workingHour
                ]);

            } elseif (!$restTimestamp) {

                $workTimestamp = Work::where('date_id', $dateStamp->id)->where('user_id', $user->id)->latest()->first();
                $start_work = new Carbon($workTimestamp->start_work);
                $end_work = new carbon($workTimestamp->end_work);
                $work_time = $start_work->diffInMinutes($end_work);
                $workingHour = round(($work_time / 10) * 0.166, 3);

                $workTimestamp->update([
                    'work_time' => $workingHour
                ]);
            }

            return redirect()->back()->with('message', 'お疲れ様でした。');

        } elseif ($workTimestamp->start_work && !$workTimestamp->end_work && ($latestDate !== $todayTimestamp)) {

            Date::create([
                'date' => Carbon::today()
            ]);

            $workDate = Date::latest()->first();

            Work::create([
                'user_id' => $user->id,
                'date_id' => $workDate->id,
                'start_work' => Carbon::now(),
                'attendance_date'=> Carbon::now()
            ]);

            $workTimestamp = Work::where('user_id', $user->id)->latest()->first();

            return redirect()->back()->with('message', '日を跨いだため出勤打刻をします。');

        }

    }


    public function restIn()
    {
        $user = Auth::user();
        $workTimestamp = Work::where('user_id', $user->id)->latest()->first();

        if (!$workTimestamp) {
            return redirect()->back()->with('message', '出勤打刻されていません。');
        }

        $restTimestamp = Rest::where('work_id', $workTimestamp->id)->latest()->first();

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
        $workTimestamp = Work::where('user_id', $user->id)->latest()->first();

        if (!$workTimestamp) {
            return redirect()->back()->with('message', '出勤打刻されていません。');
        }

        $restTimestamp = Rest::where('work_id', $workTimestamp->id)->latest()->first();

        if(!$restTimestamp) {

            return redirect()->back()->with('message', '休憩履歴がありません');

        } elseif ($restTimestamp->start_rest && !$restTimestamp->end_rest) {


            $start_rest = new Carbon($restTimestamp->start_rest);

            $restTimestamp->update([
                'end_rest' => Carbon::now(),
            ]);

            $restTimestamp = Rest::where('work_id', $workTimestamp->id)->latest()->first();
            $end_rest = new Carbon($restTimestamp->end_rest);
            $rest_time = $start_rest->diffInMinutes($end_rest);

            $restTimestamp->update([
                'rest_time' => $rest_time
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