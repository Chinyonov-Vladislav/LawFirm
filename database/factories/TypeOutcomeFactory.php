<?php

namespace Database\Factories;

use App\Models\TypeOutcome;
use Illuminate\Database\Eloquent\Factories\Factory;

class TypeOutcomeFactory extends Factory
{
    protected $model = TypeOutcome::class;
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
