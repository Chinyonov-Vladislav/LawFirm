<?php

namespace App\Http\Controllers;

use App\Models\Lawyer;
use App\Models\ServiceLawyer;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class ServiceController extends Controller
{
    public function getServices(Request $request)
    {
        $breadcrumbs = [
            ['link' => route('mainPage'), 'text' => 'Домашняя страница'],
            ['link'=>route('getServices'),'text'=>"Услуги"]
        ];
        $selected_specializations = array();
        $selected_lawyers = array();
        if($request->has("specializations"))
        {
            $specializations_from_query = $request->query('specializations');
            $selected_specializations = array_map('intval', explode(",",$specializations_from_query));
        }
        if($request->has("lawyers"))
        {
            $lawyers_from_query = $request->query('lawyers');
            $selected_lawyers = array_map('intval', explode(",",$lawyers_from_query));
        }
        $min_cost = 0;
        $max_cost = 0;
        if($request->has("min_cost"))
        {
            try {
                $min_cost = (int)$request->query("min_cost");
            }
            catch (Exception $exception)
            {
                logger("Ошибка при считывании минимальной стоимости");
            }

        }
        if($request->has("max_cost"))
        {
            try {
                $max_cost = (int)$request->query("max_cost");
            }
            catch (Exception $exception)
            {
                logger("Ошибка при считывании максимальной стоимости");
            }
        }
        $all_specializations = Specialization::all();
        foreach ($all_specializations as $specialization)
        {
            $specialization->selected = in_array($specialization->id,  $selected_specializations);
        }
        $all_lawyers = Lawyer::all();
        foreach ($all_lawyers as $lawyer)
        {
            $lawyer->selected = in_array($lawyer->id,  $selected_lawyers);
        }
        $services_query = DB::table("services")
            ->join("specializations",'services.specialization_id','=','specializations.id')
            ->join("service_lawyers",'service_lawyers.service_id','=','services.id')
            ->join("lawyers",'lawyers.id','=','service_lawyers.lawyer_id');
        if(count($selected_specializations)>0)
        {
            $services_query->whereIn("services.specialization_id", $selected_specializations);
        }
        if(count($selected_lawyers)>0)
        {
            $services_query->whereIn("service_lawyers.lawyer_id",$selected_lawyers);
        }
        if(($min_cost>0 || $max_cost>0) && $max_cost> $min_cost)
        {
            $services_query->whereBetween("service_lawyers.cost",[$min_cost, $max_cost]);
        }
        $services = $services_query->select(
            "services.name as service_name",
            "specializations.name as name_specialization",
            DB::raw("CONCAT(lawyers.second_name,' ',lawyers.first_name,' ', lawyers.middle_name) as full_name"),
            "service_lawyers.cost"
        )->get();
        $all_min_cost = ServiceLawyer::min("cost");
        $all_max_cost = ServiceLawyer::max("cost");
        return view("pages.servicesPage",compact("all_specializations",'all_lawyers', 'services',"all_min_cost","all_max_cost", 'breadcrumbs'));
    }
}
