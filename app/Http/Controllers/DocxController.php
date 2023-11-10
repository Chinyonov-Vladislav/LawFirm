<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\PhpWord;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\Shared\Html;

class DocxController extends Controller
{
    private function generateEmptyFile()
    {
        $phpWord = new PhpWord();
        $fileName = "Services" . uniqid() . '_' . time() . '.docx';
        $filePath = public_path('docs/' . $fileName);
        $phpWord->save($filePath);
        return response()->download($filePath)->deleteFileAfterSend(true);;
    }

    public function downloadInstances($id)
    {
        if ($id == Auth::id()) {
            $lawyer_info = DB::table("lawyers")
                ->where('lawyers.user_id', '=', $id)
                ->select(DB::raw("CONCAT(lawyers.second_name,' ',lawyers.first_name,' ', lawyers.middle_name) as full_name"))
                ->first();
            if ($lawyer_info != null) {
                $phpWord = new PhpWord();
                $section = $phpWord->addSection();
                $section->addText('Дела адвоката ' . $lawyer_info->full_name, ['bold' => true, 'size'=>18], array('align' => 'center'));
                $instances_lawyer = DB::table("instances")
                    ->join("requests", 'instances.request_id', '=', 'requests.id')
                    ->join("clients", 'requests.client_id', '=', 'clients.id')
                    ->join('case_services', 'instances.id', '=', 'case_services.instance_id')
                    ->join('service_lawyers', 'case_services.service_lawyer_id', '=', 'service_lawyers.id')
                    ->join('lawyers', 'service_lawyers.lawyer_id', '=', 'lawyers.id')
                    ->where("lawyers.user_id", $id)
                    ->select("instances.id",
                        'requests.topic as topic',
                        DB::raw("CONCAT(clients.second_name,' ',clients.first_name,' ', clients.middle_name) as full_name"),
                        'instances.status as status',
                        DB::raw('COALESCE(DATE_FORMAT(start_date, "%d-%m-%Y"), "") as start_date'),
                        DB::raw('COALESCE(DATE_FORMAT(end_date, "%d-%m-%Y"), "") as end_date')
                    )
                    ->distinct()
                    ->get();
                for ($i=0; $i <count($instances_lawyer);$i++) {
                    //$section = $phpWord->addSection();
                    $section->addText('Дело №'.$instances_lawyer[$i]->id, ['underline' => 'single', 'alignment' => 'center','size'=>16]);
                    $headers = ['Номер дела', 'Тема дела', "Клиент", "Статус", "Дата начала", "Дата конца"];
                    $table_first = $section->addTable([
                        'borderSize' => 6, // Толщина границы таблицы
                        'borderColor' => '000000', // Цвет границы таблицы
                        'cellMargin' => 80, // Отступ ячеек
                        'width' => 500, // Ширина таблицы
                    ]);
                    logger("Сука");
                    logger(gettype($instances_lawyer[$i]));
                    //dd($instances_lawyer);
                    if(count($headers) == count(get_object_vars((object)$instances_lawyer[$i])))
                    {
                        $index = 0;
                        foreach ($instances_lawyer[$i] as $cellData) {
                            $table_first->addRow();
                            $table_first->addCell(2000)->addText($headers[$index]);
                            $table_first->addCell(2000)->addText($cellData);
                            $index+=1;
                        }
                    }
                    $services = DB::table("case_services")
                        ->join("service_lawyers", 'case_services.service_lawyer_id', '=', 'service_lawyers.id')
                        ->join('lawyers', 'service_lawyers.lawyer_id', '=', 'lawyers.id')
                        ->join("services", 'service_lawyers.service_id', '=', 'services.id')
                        ->join('specializations', 'services.specialization_id', '=', 'specializations.id')
                        ->where("case_services.instance_id", '=', $instances_lawyer[$i]->id)
                        ->where("lawyers.user_id", '=', $id)
                        ->select("services.name as service_name", 'specializations.name as specialization_name', 'service_lawyers.cost as cost')
                        ->get();
                    if (count($services) > 0) {
                        $section->addText("Услуги адвоката", ['underline' => 'single', 'size'=>14]);
                        $headers = ['Наименование услуги', 'Специализация', "Стоимость"];
                        $table_second = $section->addTable([
                            'borderSize' => 6, // Толщина границы таблицы
                            'borderColor' => '000000', // Цвет границы таблицы
                            'cellMargin' => 80, // Отступ ячеек
                            'width' => 500, // Ширина таблицы
                        ]);
                        $table_second->addRow();
                        foreach ($headers as $header) {
                            $table_second->addCell(2000)->addText($header);
                        }
                        foreach ($services as $row) {
                            $table_second->addRow();
                            foreach ($row as $cellData) {
                                $table_second->addCell(2000)->addText($cellData);
                            }
                        }
                    }
                    $case_proccedings = DB::table('case_proceedings')
                        ->join('instances', 'case_proceedings.instance_id', '=', 'instances.id')
                        ->join("court_stages", 'case_proceedings.court_stage_id', '=', 'court_stages.id')
                        ->join("judges", 'case_proceedings.judge_id', '=', 'judges.id')
                        ->join("positions", 'judges.position_id', '=', 'positions.id')
                        ->join("courts", 'judges.court_id', '=', 'courts.id')
                        ->join('cities', 'courts.city_id', '=', 'cities.id')
                        ->where('instances.id', '=', $instances_lawyer[$i]->id)
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
                    if (count($case_proccedings) > 0) {
                        $section->addText("Судебные заседания", ['underline' => 'single','size'=>14]);
                        $headers = ["Судья", 'Должность судьи', 'Этап суда', 'Суд', 'Адрес суда', 'Город', 'Дата начала', 'Дата конца'];
                        $table_third = $section->addTable([
                            'borderSize' => 6, // Толщина границы таблицы
                            'borderColor' => '000000', // Цвет границы таблицы
                            'cellMargin' => 80, // Отступ ячеек
                            'width' => 500, // Ширина таблицы
                        ]);
                        $table_third->addRow();
                        foreach ($headers as $header) {
                            $table_third->addCell(2000)->addText($header);
                        }
                        foreach ($case_proccedings as $row) {
                            $table_third->addRow();
                            foreach ($row as $cellData) {
                                $table_third->addCell(2000)->addText($cellData);
                            }
                        }
                    }
                    $outcomes = DB::table('instances')
                        ->join("outcomes", 'instances.id', '=', 'outcomes.instance_id')
                        ->join("type_outcomes", 'type_outcomes.id', '=', 'outcomes.type_outcome_id')
                        ->where("instances.id", '=', $instances_lawyer[$i]->id)
                        ->select("type_outcomes.name as type_outcome",
                            DB::raw("CASE
            WHEN outcomes.monetary_penalty IS NOT NULL THEN CONCAT('Количество денег: ', outcomes.monetary_penalty)
            WHEN outcomes.count_years IS NOT NULL THEN CONCAT('Количество лет: ', outcomes.count_years)
            ELSE ''
        END AS modified_column"))->get();
                    if (count($outcomes) > 0) {
                        $section->addText("Приговоры суда", ['underline' => 'single','size'=>14]);
                       $headers = ['Приговор', "Наказание"];
                        $table_four = $section->addTable([
                            'borderSize' => 6, // Толщина границы таблицы
                            'borderColor' => '000000', // Цвет границы таблицы
                            'cellMargin' => 80, // Отступ ячеек
                            'width' => 500, // Ширина таблицы
                        ]);
                        $table_four->addRow();
                        foreach ($headers as $header) {
                            $table_four->addCell(2000)->addText($header);
                        }
                        foreach ($outcomes as $row) {
                            $table_four->addRow();
                            foreach ($row as $cellData) {
                                $table_four->addCell(2000)->addText($cellData);
                            }
                        }
                    }
                    if($i != count($instances_lawyer)-1) {
                        $section->addPageBreak();
                    }
                }
                $fileName = "Instances" . uniqid() . '_' . time() . '.docx';
                $filePath = public_path('docs/' . $fileName);
                $phpWord->save($filePath);
                return response()->download($filePath)->deleteFileAfterSend(true);
            } else {
                return $this->generateEmptyFile();
            }
        } else {
            return $this->generateEmptyFile();
        }
    }

    public function downloadServices($id)
    {
        if ($id == Auth::id()) {
            $lawyer_info = DB::table("lawyers")
                ->where('lawyers.user_id', '=', $id)
                ->select(DB::raw("CONCAT(lawyers.second_name,' ',lawyers.first_name,' ', lawyers.middle_name) as full_name"))
                ->first();
            if ($lawyer_info != null) {
                $services = DB::table("lawyers")
                    ->join("service_lawyers", 'lawyers.id', '=', 'service_lawyers.lawyer_id')
                    ->join('services', 'service_lawyers.service_id', '=', 'services.id')
                    ->join("specializations", 'services.specialization_id', '=', 'specializations.id')
                    ->where('lawyers.user_id', '=', $id)
                    ->select("services.name as name_service", "specializations.name as name_specialization", 'service_lawyers.cost as cost_service')
                    ->get();
                $phpWord = new PhpWord();
                $section = $phpWord->addSection();
                $section->addText('Услуги адвоката ' . $lawyer_info->full_name, ['bold' => true, 'alignment' => 'center']);
                $table = $section->addTable([
                    'borderSize' => 6, // Толщина границы таблицы
                    'borderColor' => '000000', // Цвет границы таблицы
                    'cellMargin' => 80, // Отступ ячеек
                    'width' => 500, // Ширина таблицы
                ]);
                $table->addRow();
                $headers = ["Наименование услуги", "Специализация", "Стоимость"];
                foreach ($headers as $header) {
                    $table->addCell(2000)->addText($header);
                }
                foreach ($services as $service) {
                    $table->addRow();
                    foreach ($service as $cellData) {
                        $table->addCell(2000)->addText($cellData);
                    }
                }
                $fileName = "Services" . uniqid() . '_' . time() . '.docx';
                $filePath = public_path('docs/' . $fileName);
                $phpWord->save($filePath);
                return response()->download($filePath)->deleteFileAfterSend(true);;
            } else {
                return $this->generateEmptyFile();
            }
        } else {
            return $this->generateEmptyFile();
        }
    }
}
