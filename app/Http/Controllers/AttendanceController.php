<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Models\User;
use App\Http\Models\Work;
use App\Http\Models\Rest;

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

    public function workin()
    {
        return view('/app/attendance');
    }
    public function workout()
    {
        return view('/app/attendance');
    }
}
