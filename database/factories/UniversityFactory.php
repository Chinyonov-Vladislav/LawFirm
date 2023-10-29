<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\University;
use Illuminate\Database\Eloquent\Factories\Factory;

class UniversityFactory extends Factory
{
    protected $model = University::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "Name"=>$this->faker->text(100),
            "city_id"=>City::inRandomOrder()->first->id
        ];
    }
}
