<?php

namespace App\Http\Controllers;

use App\Models\Lawyer;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LawyerController extends Controller
{
    public function getAllLawyers(Request $request)
    {
        $breadcrumbs = [
            ['link' => route('mainPage'), 'text' => 'Домашняя страница'],
            ['link'=>route('getAllLawyers'),'text'=>"Адвокаты"]
        ];
        $selected_specializations = [];
        if ($request->has("specializations"))
        {
            $specializations_from_query = $request->query('specializations');
            $selected_specializations = explode(",",$specializations_from_query);
            $selected_specializations = array_map('intval', $selected_specializations);
        }
        $all_specializations = Specialization::all();
        foreach ($all_specializations as $specialization)
        {
            $specialization->selected = in_array($specialization->id,  $selected_specializations);
        }
        $resulted_lawyers = [];
        $lawyers = Lawyer::all();
        foreach($lawyers as $lawyer)
        {
            $specializations = DB::table("lawyers")
                ->join("service_lawyers",'lawyers.id','=','service_lawyers.lawyer_id')
                ->join("services",'service_lawyers.service_id','=','services.id')
                ->join("specializations",'services.specialization_id','=','specializations.id')
                ->where("lawyers.id",'=', $lawyer->id)
                ->select("specializations.id as specialization_id","specializations.name as specialization_name")
                ->groupBy("specialization_id","specialization_name")
                ->get();
            $lawyer->specializations = $specializations;
            if(count($selected_specializations)==0)
            {
                $resulted_lawyers[] = $lawyer;
            }
            else {
                $ids_specializations_current_lawyer = $lawyer->specializations->pluck("specialization_id");
                if (count(array_intersect($selected_specializations, collect($ids_specializations_current_lawyer)->values()->toArray())) > 0) {
                    $resulted_lawyers[] = $lawyer;
                }
            }
        }
        $lawyers = $resulted_lawyers;
        return view("pages.LawyersPage", compact('lawyers', 'all_specializations', 'breadcrumbs'));
    }
    public function getLawyerPage($id)
    {

        $lawyer_info = Lawyer::where("id",'=',$id)
            ->with(["user"=>function($query){
                $query->select('id',"email");
            },
                'services.specialization',
                'university.city',])
            ->firstOrFail();
        /*$lawyer_instances_percentages = DB::table(DB::raw("(SELECT DISTINCT instances.id, specializations.name,instances.status FROM instances
                JOIN case_services ON instances.id = case_services.instance_id
                JOIN service_lawyers ON case_services.service_lawyer_id = service_lawyers.id
                JOIN lawyers ON service_lawyers.lawyer_id = lawyers.id
                JOIN services ON service_lawyers.service_id = services.id
                JOIN specializations ON services.specialization_id = specializations.id
                WHERE lawyers.id = '$id' and instances.status = \"Выиграно\") as t"))
            ->select("t.name", 't.status', DB::raw("COUNT(*) as count"))
            ->groupBy("t.name", 't.status')
            ->get();*/

        $lawyer_instances_percentages = DB::table(DB::raw("(SELECT specializations.name, instances.status FROM instances
                JOIN case_services ON instances.id = case_services.instance_id
                JOIN service_lawyers ON case_services.service_lawyer_id = service_lawyers.id
                JOIN lawyers ON service_lawyers.lawyer_id = lawyers.id
                JOIN services ON service_lawyers.service_id = services.id
                JOIN specializations ON services.specialization_id = specializations.id
                WHERE lawyers.id = '$id') as t"))
            ->select("t.name",
                DB::raw("CAST(COUNT(*) AS SIGNED) as total_count"),
                DB::raw("CAST(SUM(CASE WHEN t.status = 'Выиграно' THEN 1 ELSE 0 END) AS SIGNED) as won_count"),
                DB::raw("CAST((SUM(CASE WHEN t.status = 'Выиграно' THEN 1 ELSE 0 END) / COUNT(*)) * 100 AS DECIMAL(5,2)) as win_percentage"))
            ->groupBy("t.name")
            ->get();

        $breadcrumbs = [
            ['link' => route('mainPage'), 'text' => 'Домашняя страница'],
            ['link'=>route('getAllLawyers'),'text'=>"Адвокаты"],
            ['link'=>route("getLawyerPage", $id), 'text'=>"Адвокат {$lawyer_info->second_name} {$lawyer_info->first_name} {$lawyer_info->middle_name}"]
        ];
        //$lawyer_info = DB::table("lawyers")->where("id",'=',$id)->firstOr;
        return view("pages.LawyerPage",compact('lawyer_info',
            'breadcrumbs','lawyer_instances_percentages'));
    }
}
