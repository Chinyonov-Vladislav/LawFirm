<?php

namespace Database\Seeders;

use App\Models\ServiceLawyer;
use Illuminate\Database\Seeder;

class ServiceLawyerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //ServiceLawyer::factory()->count(5)->create();
        $service_lawyers = [
            ['service_id'=>1,'lawyer_id'=>1,'cost'=>12000],
            ['service_id'=>3,'lawyer_id'=>1,'cost'=>15000],
            ['service_id'=>5,'lawyer_id'=>1,'cost'=>15000],
        ];
        foreach ($service_lawyers as $service_lawyer)
        {
            ServiceLawyer::create([
                'service_id' => $service_lawyer['service_id'],
                'lawyer_id' => $service_lawyer['lawyer_id'],
                'cost' => $service_lawyer['cost'],
            ]);
        }
    }
}
