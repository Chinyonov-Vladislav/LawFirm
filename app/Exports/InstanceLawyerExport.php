<?php

namespace App\Exports;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class InstanceLawyerExport implements WithMultipleSheets
{
    private $id_user;
    public function __construct($id_user)
    {
        $this->id_user = $id_user;
    }

    public function sheets(): array
    {
        $sheets = [];
        $instances_lawyer = DB::table("instances")
            ->join("requests", 'instances.request_id', '=', 'requests.id')
            ->join("clients", 'requests.client_id', '=', 'clients.id')
            ->join('case_services', 'instances.id', '=', 'case_services.instance_id')
            ->join('service_lawyers', 'case_services.service_lawyer_id', '=', 'service_lawyers.id')
            ->join('lawyers', 'service_lawyers.lawyer_id', '=', 'lawyers.id')
            ->where("lawyers.user_id", $this->id_user)
            ->select("instances.id",
                'requests.topic as topic',
                DB::raw("CONCAT(clients.second_name,' ',clients.first_name,' ', clients.middle_name) as full_name"),
                'instances.status as status',
                DB::raw('COALESCE(DATE_FORMAT(start_date, "%d-%m-%Y"), "") as start_date'),
                DB::raw('COALESCE(DATE_FORMAT(end_date, "%d-%m-%Y"), "") as end_date')
            )
            ->distinct()
            ->get();
        foreach ($instances_lawyer as $item) {
            $sheets[] = new InstanceExport($item, $this->id_user);
        }
        return $sheets;
    }
}
