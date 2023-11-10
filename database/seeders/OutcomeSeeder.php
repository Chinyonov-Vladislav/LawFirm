<?php

namespace Database\Seeders;

use App\Models\Outcome;
use Illuminate\Database\Seeder;

class OutcomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Outcome::factory()->count(5)->create();
        $outcomes = [
            /*['type_outcome_id'=>1,
                'instance_id'=>1,
                'monetary_penalty'=>null,
                'count_years'=>null]*/
        ];
        foreach ($outcomes as $outcome)
        {
            Outcome::create([
                'type_outcome_id' => $outcome['type_outcome_id'],
                'instance_id' => $outcome['instance_id'],
                'monetary_penalty' => $outcome['monetary_penalty'],
                'count_years' => $outcome['count_years'],
            ]);
        }
    }
}
