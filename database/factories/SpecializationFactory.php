<?php

namespace Database\Factories;

use App\Models\Specialization;
use Illuminate\Database\Eloquent\Factories\Factory;

class SpecializationFactory extends Factory
{
    protected $model = Specialization::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "Name"=>$this->faker->text(100),
            "Description"=>$this->faker->text(200),
            "Icon"=>$this->faker->text
        ];
    }
}
