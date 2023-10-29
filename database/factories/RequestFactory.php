<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Request;
use Illuminate\Database\Eloquent\Factories\Factory;

class RequestFactory extends Factory
{
    protected $model = Request::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "Topic"=>$this->faker->realText(255),
            "Description"=>$this->faker->realText(5000),
            "DateRequest"=>$this->faker->date,
            "Status"=>function(){
                $level_education_array = array("В рассмотрении","Принято", "Отклонено");
                return $level_education_array[array_rand($level_education_array)];
            },
            "client_id"=>Client::inRandomOrder()->first->id,
        ];
    }
}
