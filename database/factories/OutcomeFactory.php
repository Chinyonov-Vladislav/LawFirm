<?php

namespace Database\Factories;

use App\Models\Instance;
use App\Models\Outcome;
use App\Models\TypeOutcome;
use Illuminate\Database\Eloquent\Factories\Factory;

class OutcomeFactory extends Factory
{
    protected $model = Outcome::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "type_outcome_id"=>TypeOutcome::inRandomOrder()->first->id,
            "instance_id"=>Instance::inRandomOrder()->first->id,

        ];
    }
}
