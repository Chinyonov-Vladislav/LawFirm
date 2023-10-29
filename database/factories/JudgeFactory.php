<?php

namespace Database\Factories;

use App\Models\Court;
use App\Models\Judge;
use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;

class JudgeFactory extends Factory
{
    protected $model = Judge::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "FirstName"=>$this->faker->firstName,
            "SecondName"=>$this->faker->lastName,
            "MiddleName"=>$this->faker->text,
            "position_id"=>Position::inRandomOrder()->first->id,
            "court_id"=>Court::inRandomOrder()->first->id,
        ];
    }
}
