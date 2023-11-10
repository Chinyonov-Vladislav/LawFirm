<?php

namespace App\Http\Controllers;

use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpecializationController extends Controller
{
    private $specializations;

    public function __construct()
    {
        $this->specializations = new Specialization();
    }
    public function showAllSpecializationsPage()
    {
        $breadcrumbs = [
            ['link' => route('mainPage'), 'text' => 'Домашняя страница'],
            ['link'=>route('showAllSpecializationsPage'),'text'=>"Специализации"]
        ];
        $specializations = $this->specializations->getAllSpecializations();
        return view('pages.AllSpecializationsPage', compact('breadcrumbs','specializations'));
    }
    public function getSpecialization()
    {
        $specializations = $this->specializations->getAllSpecializations();
        return response()->json(["specializations" => $specializations]);
    }

    public function showSpecializationPage($id)
    {

        $basic_info_specialization = Specialization::where("id",'=',$id)
            ->select("name","description")
            ->firstOrFail();
        $instances = DB::table("specializations")
            ->join("services", 'specializations.id', '=', 'services.specialization_id')
            ->join("service_lawyers", 'services.id', '=', 'service_lawyers.service_id')
            ->join("case_services", 'service_lawyers.id', '=', 'case_services.service_lawyer_id')
            ->where("specializations.id", '=', $id)
            ->select("case_services.instance_id")
            ->get();
        $instanceIds = $instances->pluck('instance_id')->unique()->toArray();
        $statuses = ["В процессе", "Выиграно","Проиграно"];
        $instancesData = DB::table("instances")
            ->whereIn("id", $instanceIds)
            ->select(
                DB::raw('count(*) as count_instances, status'),
            )
            ->groupBy("status")
            ->get();
        foreach ($statuses as $status)
        {
            $has_status = false;
            foreach ($instancesData as $instanceData)
            {
                logger($instancesData);
                if($instanceData->status == $status)
                {
                    $has_status = true;
                    break;
                }
            }
            if(!$has_status)
            {
                $instancesData[] = (object) ["count_instances"=>0, 'status' => $status];
            }
        }
        $lawyers_in_specialization = DB::table("specializations")
            ->join("services", 'specializations.id', '=', 'services.specialization_id')
            ->join("service_lawyers", 'services.id', '=', 'service_lawyers.service_id')
            ->join("lawyers",'service_lawyers.lawyer_id','=','lawyers.id')
            ->where("specializations.id",'=',$id)
            ->select("lawyers.*")
            ->distinct()
            ->get();
        $services_in_specialization = DB::table("specializations")
                ->join("services", 'specializations.id', '=', 'services.specialization_id')
                ->join("service_lawyers", 'services.id', '=', 'service_lawyers.service_id')
                ->join("lawyers",'service_lawyers.lawyer_id','=','lawyers.id')
                ->where("specializations.id",'=',$id)
                ->select("services.name", "cost","second_name",'first_name', 'second_name', 'middle_name')
                ->get();
        $breadcrumbs = [
            ['link' => route('mainPage'), 'text' => 'Домашняя страница'],
            ['link'=>route('showAllSpecializationsPage'),'text'=>"Специализации"],
            ['link'=>route('showSpecializationPage', $id),'text'=>$basic_info_specialization->name]
        ];
        return view("pages.SpecializationPage", compact('instancesData',
            'basic_info_specialization',
                        'lawyers_in_specialization',
                      'services_in_specialization',
                        'breadcrumbs'));
    }
}
