<?php

namespace Database\Seeders;

use App\Models\CaseProceeding;
use Illuminate\Database\Seeder;

class CaseProceedingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //CaseProceeding::factory()->count(5)->create();
        $case_proceedings = [
            ['start_date'=>"2023-10-30",'finish_date'=>'2023-10-30','judge_id'=>1,'instance_id'=>1,'court_stage_id'=>4],
        ];
        foreach ($case_proceedings as $case_proceeding)
        {
            CaseProceeding::create([
                'start_date' => $case_proceeding['start_date'],
                'finish_date' => $case_proceeding['finish_date'],
                'judge_id' => $case_proceeding['judge_id'],
                'instance_id' => $case_proceeding['instance_id'],
                'court_stage_id' => $case_proceeding['court_stage_id'],
            ]);
        }
    }
}
