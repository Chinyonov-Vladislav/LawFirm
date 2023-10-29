<?php

namespace Database\Factories;

use App\Models\Lawyer;
use App\Models\University;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LawyerFactory extends Factory
{
    protected $model = Lawyer::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "FirstName" => $this->faker->firstName,
            "SecondName" => $this->faker->lastName,
            "MiddleName" => $this->faker->text,
            "HireDate" => $this->faker->boolean(25) ? $this->faker->dateTimeThisDecade : null,
            "Images" =>function () {
                $array_image_links = array();
                $count_images = rand(1, 10);
                for ($i = 0; $i < $count_images; $i++) {
                    array_push($array_image_links, $this->faker->imageUrl);
                }
                return $array_image_links;},
            "NumberPhone"=>$this->faker->phoneNumber,
            "Email"=>$this->faker->email,
            "university_id"=>University::inRandomOrder()->first->id,
            "user_id"=>User::inRandomOrder()->first->id,
            "LevelEducation"=>function(){
                $level_education_array = array("Бакалавр", "Магистр", "Аспирант", "Доктор наук");
                return $level_education_array[array_rand($level_education_array)];
            },
        ];
    }
}
