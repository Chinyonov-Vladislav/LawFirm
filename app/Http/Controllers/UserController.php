<?php

namespace App\Http\Controllers;

use App\Exports\EmptyExport;
use App\Exports\ExportSpecializations;
use App\Exports\InstanceLawyerExport;
use App\Models\Client;
use App\Models\Instance;
use App\Models\News;
use App\Models\User;
use App\Models\Lawyer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function exportInstances($id)
    {
        $existLawyer = DB::table("users")
            ->join('lawyers','users.id','=',"lawyers.user_id")
            ->where("users.id",'=',$id)->exists();
        if($existLawyer) {
            if(Auth::id()==$id) {
                return Excel::download(new InstanceLawyerExport($id), 'lawyers.xlsx');
            }
            return Excel::download(new EmptyExport(), 'lawyers.xlsx');
        }
        else
        {
            return Excel::download(new EmptyExport(), 'lawyers.xlsx');
        }
    }
    public function exportSpecializations($id)
    {
        $existLawyer = DB::table("users")
            ->join('lawyers','users.id','=',"lawyers.user_id")
            ->where("users.id",'=',$id)->exists();
        if($existLawyer) {
            if(Auth::id()==$id) {
                return Excel::download(new ExportSpecializations($id), 'specializations.xlsx');
            }
            return Excel::download(new EmptyExport(), 'specializations.xlsx');
        }
        else
        {
            return Excel::download(new EmptyExport(), 'specializations.xlsx');
        }
    }
    public function updateDataUser(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id_user' => ['required', 'integer'],
                'username' => ['required', 'string', 'max:255'],
                'password' => ['nullable', 'string', 'min:8', 'max:255'],
                'confirm_password' => ['nullable', 'string', 'min:8', 'max:255'],
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()]);
            }
            $auth_user_id = Auth::id();
            if ($auth_user_id != $request->id_user) {
                return response()->json(["success" => false, "message" => "Вы пытаетесь поменять данные для своего аккаунта"]);
            }
            $user = User::find($auth_user_id);
            if ($user == null) {
                return response()->json(['success' => false, 'message' => "Пользователь не найден в базе данных"]);
            }
            $result_message = "";
            if ($user->name != $request->username) {
                $user->name = $request->username;
                $result_message .= "Имя пользователя было успешно обновлено\n";
            }
            if ($request->password != "") {
                if ($request->password == $request->confirm_password) {
                    $user->password = bcrypt($request->password);
                    $result_message .= "Пароль был успешно обновлен!";
                } else {
                    return response()->json(['success' => false, 'message' => "Значения переменных \"Пароль\" и \"Подтверждение пароля\" не совпадают"]);
                }
            }
            if ($result_message == "") {
                $result_message = "Не произошло никаких обновлений";
            }
            $user->save();
            return response()->json(["success" => true, "message" => $result_message]);
        } catch (Exception $exception) {
            return response()->json(['success' => false, 'message' => $exception->getMessage()]);
        }
    }

    public function getPersonalAccount($id)
    {
        if (Auth::user()->id != $id) {
            return redirect("/");
        }
        if (Auth::user()->role_id == 2) // клиент
        {
            $breadcrumbs = [
                ['link' => route('mainPage'), 'text' => 'Домашняя страница'],
                ['link' => route('getPersonalAccount', $id), 'text' => "Личный кабинет клиента"]
            ];
            $dataClient = User::with("client")->find($id)->client;
            if ($dataClient->city_id != null) {
                $city_info = DB::table("cities")->where("id", '=', $dataClient->city_id)
                    ->select("id", "Name")
                    ->get();
                $dataClient->city = $city_info[0];
            }
            $cities = DB::table("cities")->get();
            $my_requests = DB::table("requests")->where("client_id", "=", $dataClient->id)->get();
            $my_instances = DB::table("instances")
                ->join("requests", "instances.request_id", '=', 'requests.id')
                ->join("clients", 'requests.client_id', '=', 'clients.id')
                ->where("clients.user_id", '=', Auth::user()->id)
                ->orderBy("instances.created_at", 'DESC')
                ->select(
                    "instances.id as instance_id",
                    "instances.start_date",
                    "instances.end_date",
                    "instances.status",
                    "requests.topic",
                )
                ->get();

            return view("pages.ClientPersonalCabinet", compact("dataClient",
                'cities',
                "my_instances",
                'my_requests',
                'breadcrumbs'
            ));
        } else if (Auth::user()->role_id == 3) // адвокат
        {
            $breadcrumbs = [
                ['link' => route('mainPage'), 'text' => 'Домашняя страница'],
                ['link' => route('getPersonalAccount', $id), 'text' => "Личный кабинет адвоката"]
            ];
            $dataLawyer = Lawyer::with(
                "user",
                'services.specialization',
                'university.city')
                ->where("user_id", '=', $id)
                ->first();
            $instances_lawyer = Instance::whereHas('case_services.service_lawyer.lawyer', function ($query) use ($id) {
                $query->where('lawyers.user_id', $id);
            })->with(['request' => function ($query) {
                    $query->select('requests.id', 'requests.topic', 'requests.description', "requests.client_id")
                        ->with(['client' => function ($query) {
                            $query->select("clients.id",
                                DB::raw("CONCAT(clients.second_name,' ', clients.first_name, ' ', clients.middle_name) as full_name_client")
                            );
                        }]);
                },
                'case_services'=>function($query){
                    $query->with(["service_lawyer"=>function($query){
                        $query->with(["service"=>function($query){
                            $query->with("specialization");
                        }]);
                    }]);
                },
                'case_proceeding'=>function($query){
                    $query->with(['court_stage']);
                    $query->with(['judge'=>function($query){
                        $query->with(['court'=>function($query){
                            $query->with('city');
                        }]);
                        $query->with(['position']);
                    }]);
                },
                'types_outcome'
                ])->get();
            $instances_counts = DB::table(DB::raw("(SELECT DISTINCT instances.* FROM instances
                JOIN case_services ON instances.id = case_services.instance_id
                JOIN service_lawyers ON case_services.service_lawyer_id = service_lawyers.id
                JOIN lawyers ON service_lawyers.lawyer_id = lawyers.id
                WHERE lawyers.user_id = '$id' ) as t"))
                ->select('t.status', DB::raw('COUNT(*) as count'))
                ->groupBy('t.status')
                ->get();
            $statuses = ["В процессе", "Выиграно","Проиграно"];
            foreach ($statuses as $status)
            {
                $existStatus = false;
                foreach ($instances_counts as $instance)
                {
                    if($status == $instance->status)
                    {
                        $existStatus = true;
                        break;
                    }
                }
                if(!$existStatus)
                {
                    $newObject = (object) ["status" => $status, "count" => 0];
                    $instances_counts->push($newObject);
                }
            }

            $moneys_by_cases = DB::table(DB::raw("(SELECT instances.id as instance_id, requests.topic as topic,
            service_lawyers.cost FROM instances
                JOIN requests ON instances.request_id = requests.id
                JOIN case_services ON instances.id = case_services.instance_id
                JOIN service_lawyers ON case_services.service_lawyer_id = service_lawyers.id
                JOIN lawyers ON service_lawyers.lawyer_id = lawyers.id
                WHERE lawyers.user_id = '$id' and instances.status = \"Выиграно\") as t"))
                ->select('t.instance_id','t.topic', DB::raw('SUM(cost) as total_cost'))
                ->groupBy("t.instance_id", 't.topic')
                ->get();
            $instances_counts_by_rating = DB::table(DB::raw("(SELECT DISTINCT instances.* FROM instances
                JOIN case_services ON instances.id = case_services.instance_id
                JOIN service_lawyers ON case_services.service_lawyer_id = service_lawyers.id
                JOIN lawyers ON service_lawyers.lawyer_id = lawyers.id
                WHERE lawyers.user_id = '$id' ) as t"))
                ->select('t.rating', DB::raw('COUNT(*) as count'))
                ->groupBy('t.rating')
                ->get();

            $ratings = [1, 2,3,4,5];
            foreach ($ratings as $rating)
            {
                $existRating = false;
                foreach ($instances_counts_by_rating as $instance_rating)
                {
                    if($rating == $instance_rating->rating)
                    {
                        $existRating = true;
                        break;
                    }
                }
                if(!$existRating)
                {
                    $newObject = (object) ["rating" => $rating, "count" => 0];
                    $instances_counts_by_rating->push($newObject);
                }
            }
            $instances_counts_by_rating = collect($instances_counts_by_rating)->sortBy('rating')->values()->all();
            $news = News::where("lawyer_id", '=', $dataLawyer->id)->get();
            //$news = array();
            return view("pages.LawyerPersonalCabinet", compact("dataLawyer",
                'instances_lawyer',
                'breadcrumbs',
                'instances_counts',
                'moneys_by_cases',
                'instances_counts_by_rating',
                'news'
            ));
        } else // админ
        {
            return redirect("/admin");
        }
    }

    public
    function saveInfoClient(Request $request)
    {
        try {
            logger("saveInfoClient");
            logger($request);
            $id_user = Auth::user()->id;
            //$client_info = DB::table("clients")->where("user_id",'=', $id_user)->first();
            $client_info = Client::where("user_id", $id_user)->first();
            $client_info->first_name = $request->first_name;
            $client_info->second_name = $request->second_name;
            $client_info->middle_name = $request->middle_name;
            $client_info->number_phone = $request->number_phone;
            $client_info->address = $request->address;
            $client_info->birthday = $request->birthday;
            $client_info->city_id = $request->city_id;
            $client_info->save();
            return response()->json(["error" => false]);
        } catch (Exception $exception) {
            logger("Ошибка при изменении личных данных!");
            logger($exception->getMessage());
            return response()->json(["error" => true, "message" => $exception->getMessage()]);
        }
    }

    public
    function updateDataInfoLawyer(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id_lawyer' => ['required', 'integer'],
                'second_name' => ['required', 'string', 'max:255'],
                'first_name' => ['required', 'string', 'max:255'],
                'middle_name' => ['required', 'string', 'max:255'],
                'number_phone' => ['required', 'string', 'max:255'],
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()]);
            }
            $auth_user_id = Auth::user()->id;
            $lawyer_from_database = Lawyer::find($request->id_lawyer);
            if ($lawyer_from_database == null) {
                return response()->json(['success' => false, 'message' => "Адвокат с id = " . $request->lawyer_id . " не найден"]);
            }
            if ($lawyer_from_database->user_id != $auth_user_id) {
                return response()->json(['success' => false, 'message' => "Вы пытаетесь отредактировать данные адвоката, которые не относятся к авторизованному пользователю"]);
            }
            $lawyer_from_database->second_name = $request->second_name;
            $lawyer_from_database->first_name = $request->first_name;
            $lawyer_from_database->middle_name = $request->middle_name;
            $lawyer_from_database->number_phone = $request->number_phone;
            $lawyer_from_database->save();
            return response(['success' => true, "message" => "Данные были успешно обновлены"]);
        } catch (Exception $exception) {
            return response()->json(['success' => false, "message" => $exception->getMessage()]);
        }
    }

    public
    function updateImageLawyer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_lawyer' => ['required', 'integer'],
            'images' => ['required', 'array'],
            'images.*' => ['required', 'string']
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        $auth_user_id = Auth::user()->id;
        $lawyer_from_database = Lawyer::find($request->id_lawyer);
        if ($lawyer_from_database == null) {
            return response()->json(['success' => false, 'message' => "Адвокат с id = " . $request->lawyer_id . " не найден"]);
        }
        if ($lawyer_from_database->user_id != $auth_user_id) {
            return response()->json(['success' => false, 'message' => "Вы пытаетесь отредактировать фотографии адвоката, которые не относятся к авторизованному пользователю"]);
        }
        $lawyer_from_database->images = $request->images;
        $lawyer_from_database->save();
        return response()->json(['success' => true, "message" => "Фотографии адвоката были успешно сохранены!"]);
    }
}
