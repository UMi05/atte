<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Work;
use App\Models\Rest;

class CheckController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('/app/check', ['users' => $users]);
    }
}
