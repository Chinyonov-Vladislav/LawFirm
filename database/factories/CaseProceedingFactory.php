<?php

namespace Database\Factories;

use App\Models\CaseProceeding;
use App\Models\CourtStage;
use App\Models\Instance;
use App\Models\Judge;
use Illuminate\Database\Eloquent\Factories\Factory;

class CaseProceedingFactory extends Factory
{
    protected $model = CaseProceeding::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "StartDate"=>$this->faker->date(),
            "FinishDate"=>$this->faker->date(),
            "judge_id"=>Judge::inRandomOrder()->first->id,
            "instance_id"=>Instance::inRandomOrder()->first->id,
            "court_stage_id"=>CourtStage::inRandomOrder()->first->id,
        ];
    }
}
