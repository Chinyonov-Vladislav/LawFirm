<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\Specialization;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    protected $model = Service::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "Name"=>$this->faker->text(100),
            "specialization_id"=>Specialization::inRandomOrder()->first->id,
        ];
    }
}
