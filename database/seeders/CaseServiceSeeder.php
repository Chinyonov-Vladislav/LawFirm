<?php

namespace Database\Seeders;

use App\Models\CaseService;
use Illuminate\Database\Seeder;

class CaseServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //CaseService::factory()->count(5)->create();
        $case_services = [
            ['instance_id'=>1,'service_lawyer_id'=>1],
            ['instance_id'=>1,'service_lawyer_id'=>3]
        ];
        foreach ($case_services as $case_service)
        {
            CaseService::create([
                'instance_id' => $case_service['instance_id'],
                'service_lawyer_id' => $case_service['service_lawyer_id'],
            ]);
        }
    }
}
