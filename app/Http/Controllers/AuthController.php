<?php

namespace App\Http\Controllers;

use App\Mail\ResetPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Mockery\Exception;

class AuthController extends Controller
{
    public function checkAuthUser()
    {

        return response()->json(["UserAuth"=>Auth::user()]);
    }
    public function restorePassword()
    {
        $breadcrumbs = [
            ['link' => route('mainPage'), 'text' => 'Домашняя страница'],
            ['link'=>route('login'),'text'=>"Авторизация"],
            ['link'=>route("restorePassword"), 'text'=>"Восстановление пароля"]
        ];
        return view("pages.restorePasswordPage", compact('breadcrumbs'));
    }
    public function resetPassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => ['required', 'email', 'max:255'],
            ]);
            if($validator->fails())
            {
                return response()->json(['errors'=>$validator->errors()]);
            }
            $user = User::where("email", $request->email)->first();
            if($user==null)
            {
                return response()->json(['success'=>false, 'message'=>"Пользователь с заданным email - адресом не существует"]);
            }
            $token = Str::random(60);
            $user->token = $token;
            $user->save();
            Mail::to($request->email)->send(new ResetPassword($user->name, $token));
            return response()->json(['success'=>true, "message"=>"Сообщение со сменой пароля было отправлено на вашу почту"]);
        }
        catch (Exception $exception)
        {
            return response()->json(['success'=>false, 'message'=>$exception->getMessage()]);
        }
    }
    public function showPageChangePassword($token)
    {
        $user = User::where('token', "=",$token)->first();
        if($user)
        {
            $email = $user->email;
            return view('pages.changePasswordPage', compact('email'));
        }
        else
        {
            $text_error = "Не найден пользователь для смены пароля";
            return view("errors.GeneralError", compact("text_error"));
        }
    }
    public function updatePasswordUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required'],
            'password'=>["required", 'min:8'],
            'confirm_password'=>["required", 'same:password']
        ]);
        if($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()]);
        }
        $user = User::where("email", $request->email)->first();
        if($user)
        {
            $user->token = "";
            $user->password = Hash::make($request->password);
            $user->save();
            return response()->json(['success'=>true, 'message'=>"Пароль был успешно обновлен"]);
        }
        else
        {
            return response()->json(['success'=>false, 'message'=>"Не найден аккаунт пользователя для смены пароля"]);
        }
    }
}
