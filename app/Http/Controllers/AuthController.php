<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function checkAuthUser()
    {
        return response()->json(["UserAuth"=>Auth::user()]);
    }
}
