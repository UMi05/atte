<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Date;
use App\Models\Date_User;
use App\Models\Work;
use App\Models\Rest;
use Carbon\Carbon;
use DateTime;

use function GuzzleHttp\Promise\all;

class CheckController extends Controller
{
    public function index()
    {

        $workTable = Date::get()->first();

        if (!$workTable) {
            return redirect()->back()->with('message', '勤務履歴がありません。');
        }

        $allDate = Date_User::join('dates', 'dates.id', 'date_users.date_id')
        ->select('date')
        ->orderBy('date', 'asc')
        ->simplePaginate(1);

        $users = User::join('works', 'works.user_id', 'users.id')
        ->paginate(5);
        // dd($users);

        return view('check', compact('allDate', 'users'));

    }

}
