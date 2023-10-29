<?php

namespace Database\Factories;

use App\Models\CaseService;
use App\Models\Instance;
use App\Models\ServiceLawyer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CaseServiceFactory extends Factory
{
    protected $model = CaseService::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "instance_id"=>Instance::inRandomOrder()->first->id,
            "service_lawyer_id"=>ServiceLawyer::inRandomOrder()->first->id,
        ];
    }
}
