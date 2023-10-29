<?php

namespace Database\Factories;

use App\Models\CourtStage;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourtStageFactory extends Factory
{
    protected $model = CourtStage::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "Name"=>$this->faker->text
        ];
    }
}
