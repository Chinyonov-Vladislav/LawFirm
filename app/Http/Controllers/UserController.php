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
        $hasClientAccount = DB::table("clients")->where("user_id", '=', $id)->exists();
        $hasLawyerAccount = DB::table("lawyers")->where("user_id", '=', $id)->exists();
        if ($hasClientAccount) {
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
        } else if ($hasLawyerAccount) {
            return redirect("/");
        } else {
            return redirect("/");
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
            $client_info->FirstName = $request->FirstName;
            $client_info->SecondName = $request->SecondName;
            $client_info->MiddleName = $request->MiddleName;
            $client_info->NumberPhone = $request->NumberPhone;
            $client_info->Address = $request->Address;
            $client_info->Birthday = $request->Birthday;
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
