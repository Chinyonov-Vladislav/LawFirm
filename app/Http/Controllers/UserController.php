<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use function Symfony\Component\String\b;

class UserController extends Controller
{
    public function getPersonalAccount($id)
    {
        if (Auth::user()->id != $id) {
            return redirect("/");
        }
        if(Auth::user()->role_id == 2) // клиент
        {
            $dataClient = User::with("client")->find($id)->client;
            if ($dataClient->city_id!=null) {
                $city_info = DB::table("cities")->where("id", '=', $dataClient->city_id)
                    ->select("id", "Name")
                    ->get();
                $dataClient->city = $city_info[0];
            }
            logger("Данные клиента");
            logger($dataClient);
            $cities = DB::table("cities")->get();
            $my_requests = DB::table("requests")->where("client_id","=", $dataClient->id)->get();
            return view("pages.ClientPersonalCabinet", compact("dataClient", 'cities','my_requests'));
        }
        else if(Auth::user()->role_id==3) // адвокат
        {

        }
        else // админ
        {
            return redirect("/admin");
        }
    }
    public function saveInfoClient(Request $request)
    {
        try {
            logger("saveInfoClient");
            logger($request);
            $id_user = Auth::user()->id;
            //$client_info = DB::table("clients")->where("user_id",'=', $id_user)->first();
            $client_info = Client::where("user_id",$id_user)->first();
            $client_info->first_name = $request->first_name;
            $client_info->second_name = $request->second_name;
            $client_info->middle_name = $request->middle_name;
            $client_info->number_phone = $request->number_phone;
            $client_info->address = $request->address;
            $client_info->birthday = $request->birthday;
            $client_info->city_id = $request->city_id;
            $client_info->save();
            return response()->json(["error"=>false]);
        }
        catch (Exception $exception)
        {
            logger("Ошибка при изменении личных данных!");
            logger($exception->getMessage());
            return response()->json(["error"=>true, "message"=>$exception->getMessage()]);
        }
    }
}
