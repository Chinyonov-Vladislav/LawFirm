<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

class InstanceExport implements FromCollection, WithTitle
{
    private $instance;
    private $user_id;
    public function __construct($instance, $user_id)
    {
        $this->instance = $instance;
        $this->user_id = $user_id;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $output[] = ['Номер дела', 'Тема дела', "Клиент", "Статус", "Дата начала", "Дата конца"];
        $output[] = $this->instance;
        $output[] = [''];
        $services = DB::table("case_services")
            ->join("service_lawyers", 'case_services.service_lawyer_id', '=', 'service_lawyers.id')
            ->join('lawyers', 'service_lawyers.lawyer_id', '=', 'lawyers.id')
            ->join("services", 'service_lawyers.service_id', '=', 'services.id')
            ->join('specializations', 'services.specialization_id', '=', 'specializations.id')
            ->where("case_services.instance_id", '=', $this->instance->id)
            ->where("lawyers.user_id", '=', $this->user_id)
            ->select("services.name as service_name", 'specializations.name as specialization_name', 'service_lawyers.cost as cost')
            ->get();
        if (count($services)>0) {
            $output[] = ['Наименование услуги', 'Специализация', "Стоимость"];
            foreach ($services as $service) {
                $output[] = $service;
            }
            $output[] = [''];
        }
        $case_proccedings = DB::table('case_proceedings')
            ->join('instances', 'case_proceedings.instance_id', '=', 'instances.id')
            ->join("court_stages", 'case_proceedings.court_stage_id', '=', 'court_stages.id')
            ->join("judges", 'case_proceedings.judge_id', '=', 'judges.id')
            ->join("positions", 'judges.position_id', '=', 'positions.id')
            ->join("courts", 'judges.court_id', '=', 'courts.id')
            ->join('cities', 'courts.city_id', '=', 'cities.id')
            ->where('instances.id', '=', $this->instance->id)
            ->select(
                DB::raw("CONCAT(judges.second_name,' ',judges.first_name,' ', judges.middle_name) as full_name"),
                "positions.name as position_name",
                'court_stages.name as court_stage_name',
                "courts.name_court",
                'courts.address as address_court',
                'cities.name as name_city',
                DB::raw('COALESCE(DATE_FORMAT(case_proceedings.start_date, "%d-%m-%Y"), "") as start_date'),
                DB::raw('COALESCE(DATE_FORMAT(case_proceedings.finish_date, "%d-%m-%Y"), "") as finish_date')
            )->get();
        if(count($case_proccedings)>0) {
            $output[] = ["Судья",'Должность судьи','Этап суда','Суд','Адрес суда','Город','Дата начала','Дата конца'];
            foreach ($case_proccedings as $case_procceding) {
                $output[] = $case_procceding;
            }
            $output[] = [''];
        }
        $outcomes = DB::table('instances')
            ->join("outcomes", 'instances.id', '=', 'outcomes.instance_id')
            ->join("type_outcomes", 'type_outcomes.id', '=', 'outcomes.type_outcome_id')
            ->where("instances.id", '=', $this->instance->id)
            ->select("type_outcomes.name as type_outcome",
                DB::raw("CASE
            WHEN outcomes.monetary_penalty IS NOT NULL THEN CONCAT('Количество денег: ', outcomes.monetary_penalty)
            WHEN outcomes.count_years IS NOT NULL THEN CONCAT('Количество лет: ', outcomes.count_years)
            ELSE ''
        END AS modified_column"))->get();
        if(count($outcomes)>0) {
            $output[] = ['Приговор', "Наказание"];
            foreach ($outcomes as $outcome) {
                $output[] = $outcome;
            }
        }
        return collect($output);
    }

    public function title(): string
    {
        return "Дело №".$this->instance->id;
    }
}
