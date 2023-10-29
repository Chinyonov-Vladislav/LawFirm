<?php

namespace Database\Factories;

use App\Models\Lawyer;
use App\Models\Service;
use App\Models\ServiceLawyer;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceLawyerFactory extends Factory
{
    protected $model = ServiceLawyer::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "service_id"=>Service::inRandomOrder()->first->id,
            "lawyer_id"=>Lawyer::inRandomOrder()->first->id,
            "Cost"=>$this->faker->randomFloat(2, 0, 999999999999.99)
        ];
    }
}
