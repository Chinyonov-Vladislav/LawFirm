<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Court;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourtFactory extends Factory
{
    protected $model = Court::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "NameCourt"=>$this->faker->text,
            "Address"=>$this->faker->address,
            "NumberPhone"=>$this->faker->phoneNumber,
            "city_id"=>City::inRandomOrder()->first->id
        ];
    }
}
