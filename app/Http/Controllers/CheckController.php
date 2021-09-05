<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Work;
use App\Models\Rest;
use Carbon\Carbon;

class CheckController extends Controller
{
    public function index()
    {
        $users = User::all();
        $dates = Work::with('user')->simplePaginate(1);
        $workTs = Work::with('user')->get();

        return view('/app/check',compact('users', 'dates', 'workTs'));
    }
}
