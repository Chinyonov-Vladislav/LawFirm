<?php

namespace App\Http\Controllers;

use App\Models\Instance;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InstanceController extends Controller
{
    public function showInfoInstance($id)
    {
        $auth_user = Auth::user();
        $title_for_personal_cabinet = "";
        if($auth_user->role_id ==2)
        {
            $title_for_personal_cabinet = "Личный кабинет клиента";
        }
        if($auth_user->role_id ==3)
        {
            $title_for_personal_cabinet = "Личный кабинет адвоката";
        }
        $breadcrumbs = [
            ['link' => route('mainPage'), 'text' => 'Домашняя страница'],
            ['link'=>route('getPersonalAccount',$auth_user->id ),'text'=>$title_for_personal_cabinet],
            ['link'=>route('infoInstance', $id),'text'=>"Дело №".$id]
        ];
        $exist_instance = Instance::where("id",'=',$id)->first();
        if($exist_instance == null)
        {
            $text_error = "Записи о деле №".$id." нет в базе данных";
            return view("errors.GeneralError",compact("text_error"));
        }
        $isUserLawyer = Auth::user()->role_id ==3;
        $id_current_user = Auth::user()->id;
        $id_user_owner = DB::table("instances")
            ->join("requests",'instances.request_id','=','requests.id')
            ->join("clients",'requests.client_id','=','clients.id')
            ->join("users",'clients.user_id','=','users.id')
            ->select("users.id")
            ->where("instances.id",'=', $id)->first()->id;
        if($isUserLawyer || $id_user_owner == $id_current_user)
        {
            $basic_info_instance = DB::table("instances")
                ->join("requests",'instances.request_id','=','requests.id')
                ->where("instances.id",'=',$id)
                ->select(
                    "instances.id as id_instance",
                    "requests.topic",
                    'requests.description',
                    'instances.start_date',
                    'instances.end_date',
                    'instances.status',
                    'instances.feedback',
                    'instances.rating'
                )->first();
            $services_case = DB::table("instances")
                ->join("case_services",'instances.id','=','case_services.instance_id')
                ->join("service_lawyers",'case_services.service_lawyer_id','=','service_lawyers.id')
                ->join("services",'service_lawyers.service_id',"=","services.id")
                ->join("lawyers",'lawyers.id','=','service_lawyers.lawyer_id')
                ->where("instances.id", '=', $id)
                ->select(
                    "services.name as service_name",
                    "services.id as id_service",
                    "service_lawyers.cost as cost",
                    'lawyers.id as lawyer_id',
                    'lawyers.first_name as first_name',
                    "lawyers.second_name as second_name",
                    'lawyers.middle_name as  middle_name')
                ->get();
            $case_proceeding = DB::table("instances")
                ->join("case_proceedings", 'instances.id' ,'=','case_proceedings.instance_id')
                ->join("court_stages",'case_proceedings.court_stage_id','=','court_stages.id')
                ->join("judges",'case_proceedings.judge_id','=','judges.id')
                ->join("positions",'judges.position_id','=','positions.id')
                ->join("courts",'judges.court_id','=','courts.id')
                ->join("cities",'courts.city_id','=','cities.id')
                ->where("instances.id",'=',$id)
                ->select(
                    "case_proceedings.id as id_process",
                        "court_stages.name as name_court_stage",
                        "case_proceedings.start_date", "case_proceedings.finish_date",
                        "judges.first_name","judges.second_name","judges.middle_name",
                        'positions.name as position_name',
                        'courts.name_court as court_name',
                        'cities.name as name_city'
                )->get();
            $outcomes = DB::table("instances")
                ->join("outcomes",'instances.id','=','outcomes.instance_id')
                ->join('type_outcomes','outcomes.type_outcome_id','=','type_outcomes.id')
                ->where("instances.id",'=',$id)
                ->select("type_outcomes.name as type_outcome_name", 'outcomes.monetary_penalty', 'outcomes.count_years')
                ->get();
            $data_about_instance = array(
                "basic_info_instance" => $basic_info_instance,
                "services_case"=> $services_case,
                "case_procceding"=>$case_proceeding,
                'outcomes'=>$outcomes
            );
            return view('pages.InstancePage', compact("data_about_instance",'breadcrumbs'));
        }
        else
        {
            $text_error = "Просмотр дела возможен только для адвокатов и владельца дела";
            return view("errors.GeneralError",compact("text_error"));
        }
    }
    public function saveFeedback(Request $request): JsonResponse
    {
        try
        {
            logger($request->all());
            $validator = Validator::make($request->all(), [
                'instance_id' => ['required', 'integer'],
                "feedback_text"=>['nullable',"string","max:255"],
                "rating"=>["nullable","integer","min:0","max:5"]
            ]);
            if($validator->fails())
            {
                return response()->json(['errors'=>$validator->errors()]);
            }
            $auth_user_id = Auth::id();
            $instance = Instance::find($request->instance_id);
            if($instance == null)
            {
                return response()->json(['success'=>false, 'message'=>"Не найдена запись о деле №".$request->instance_id]);
            }
            if($instance->status === "В процессе")
            {
                return response()->json(['success'=>false, "message"=>"Вы не можете оставить отзыв о деле №".$request->instance_id.", так как оно находится в процессе решения"]);
            }
            $owner_instance = DB::table('instances')
                ->join("requests","instances.request_id","=","requests.id")
                ->join("clients",'requests.client_id','=','clients.id')
                ->join("users",'clients.user_id','=','users.id')
                ->where("instances.id",'=',$request->instance_id)
                ->select("users.id as user_id")->first();
            if($owner_instance == null)
            {
                return response()->json(['success'=>false, 'message'=>"Не найден владелец дела №".$request->instance_id]);
            }
            if($auth_user_id != $owner_instance->user_id)
            {
                return response()->json(['success'=>false, 'message'=>"Авторизованный пользователь не является владельцем дела №".$request->instance_id]);
            }
            $instance->feedback = $request->feedback_text;
            $instance->rating = $request->rating;
            $instance->save();
            return response()->json(["success"=>true, "message"=>"Отзыв о деле №".$request->instance_id." был успешно сохранён"]);
        }
        catch (Exception $exception)
        {
            return response()->json(["success"=>true, "message"=>$exception->getMessage()]);
        }
    }
    public function deleteFeedback($id)
    {
        try {
            $auth_user_id = Auth::id();
            $instance = Instance::find($id);
            if($instance == null)
            {
                return response()->json(['success'=>false, 'message'=>"Не найдена запись о деле №".$id]);
            }
            if($instance->status === "В процессе")
            {
                return response()->json(['success'=>false, "message"=>"Вы не можете удалить отзыв о деле №".$id.", так как оно находится в процессе решения"]);
            }
            $owner_instance = DB::table('instances')
                ->join("requests","instances.request_id","=","requests.id")
                ->join("clients",'requests.client_id','=','clients.id')
                ->join("users",'clients.user_id','=','users.id')
                ->where("instances.id",'=',$id)
                ->select("users.id as user_id")->first();
            if($owner_instance == null)
            {
                return response()->json(['success'=>false, 'message'=>"Не найден владелец дела №".$id]);
            }
            if($auth_user_id != $owner_instance->user_id)
            {
                return response()->json(['success'=>false, 'message'=>"Авторизованный пользователь не является владельцем дела №".$id]);
            }
            $instance->feedback = null;
            $instance->rating = null;
            $instance->save();
            return response()->json(['success'=>true, "message"=>"Ваш отзыв был удален"]);
        }
        catch (Exception $exception)
        {
            return response()->json(['success'=>false, "message"=>$exception->getMessage()]);
        }
    }
}
