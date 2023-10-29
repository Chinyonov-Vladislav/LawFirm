<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    protected $model = Client::class;
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
            "MiddleName"=>$this->faker->text(255),
            "NumberPhone"=>$this->faker->phoneNumber,
            "Email"=>$this->faker->email,
            "Address"=>$this->faker->address,
            "Birthday"=>$this->faker->dateTime,
            "user_id"=>User::inRandomOrder()->first->id,
        ];
    }
}
