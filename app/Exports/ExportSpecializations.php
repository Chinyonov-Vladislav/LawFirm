<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportSpecializations implements FromCollection, withHeadings
{
    private $id_user;
    public function __construct($id_user)
    {
        $this->id_user = $id_user;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table("lawyers")
            ->join("service_lawyers",'lawyers.id','=','service_lawyers.lawyer_id')
            ->join('services','service_lawyers.service_id','=','services.id')
            ->join("specializations",'services.specialization_id','=','specializations.id')
            ->where('lawyers.user_id','=',$this->id_user)
            ->select("services.name as name_service", "specializations.name as name_specialization", 'service_lawyers.cost as cost_service')
            ->get();
    }
    public function headings(): array
    {
        return ["Название услуги", "Специализация", "Стоимость"];
    }
}
