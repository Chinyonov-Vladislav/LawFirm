<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function checkAuthUser()
    {
        $auth_user = Auth::user();
        if(!$auth_user)
        {
            $hasClientAccount = DB::table("clients")->where("user_id","=", $auth_user->id);
            $hasLawyerAccount = DB::table("lawyers")->where("user_id","=",$auth_user->id);
            return response()->json(["UserAuth"=>Auth::user(), "hasClientAccount"=>$hasClientAccount, "hasLawyerAccount"=>$hasLawyerAccount]);
        }
        return response()->json(["UserAuth"=>Auth::user()]);
    }
}
