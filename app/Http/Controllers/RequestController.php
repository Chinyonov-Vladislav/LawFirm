<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RequestController extends Controller
{
    public function createRequest(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'topic' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string', 'max:5000'],
            ]);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }
            $user_id = Auth::user()->id;
            $client_id = DB::table("clients")->where("user_id",'=',$user_id)->first()->id;
            $new_request_user = new \App\Models\Request();
            $new_request_user->topic = $request->topic;
            $new_request_user->description = $request->description;
            $new_request_user->date_request = Carbon::now();
            $new_request_user->client_id = $client_id;
            $new_request_user->save();
            return response()->json(['error'=>false, 'new_request'=>$new_request_user]);
        }
        catch (Exception $exception)
        {
            return response()->json(["error"=>true, 'message'=>$exception->getMessage()]);
        }
    }
    public function deleteRequest($id)
    {
        try {
            $user_id = Auth::user()->id;
            $client_id = DB::table('clients')->where("user_id",'=',$user_id)->first()->id;
            $request = \App\Models\Request::find($id);
            if($request!=null) {
                if ($request->status != "В рассмотрении")
                {
                    return response()->json(["error"=>true, 'message'=>"Данная заявка не находится в статусе \"В рассмотрении\""]);
                }
                if ($client_id == $request->client_id) {
                    \App\Models\Request::destroy($id);
                    return response()->json(["error"=>false]);
                } else {
                    return response()->json(['error'=>true,'message'=>"Вы не можете удалить чужую заявку!"]);
                }
            }
            else
            {
                return response()->json(['error'=>true, 'message'=>"Заявка №".$id." не найдена"]);
            }
        }
        catch (Exception $exception)
        {
            logger("Ошибка удаления");
            logger($exception->getMessage());
            return response()->json(['error'=>true, 'message'=>$exception->getMessage()]);
        }
    }
    public function redactRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "id"=>['required','integer'],
            'topic' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
        ]);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()]);
        }
        $user_id = Auth::id();
        $client_id = DB::table("clients")->where("user_id",'=', $user_id)->first()->id;
        $request_from_bd= \App\Models\Request::find($request->id);
        if ($request_from_bd == null)
        {
            return response()->json(['error'=>true, 'message'=>"Заявка не найдена!"]);
        }
        if($request_from_bd->Status != "В рассмотрении")
        {
            return response()->json(['error'=>true, 'message'=>"Заявка не может быть изменена, так как имеет статус отличный от \"В рассмотрении\"!"]);
        }
        if($request_from_bd->user_id == $client_id)
        {
            $request_from_bd->topic = $request->topic;
            $request_from_bd->description = $request->description;
            $request_from_bd->save();
            return response()->json(['error'=>false]);
        }
        else
        {
            return response()->json(['error'=>true, 'message'=>"Невозможно отредактировать не вашу заявку!"]);
        }
    }
}
