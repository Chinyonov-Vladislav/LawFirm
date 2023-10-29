<?php

namespace Database\Factories;

use App\Models\Lawyer;
use App\Models\News;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsFactory extends Factory
{
    protected $model = News::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "Title"=>$this->faker->text(255),
            "Description"=>$this->faker->text(5000),
            "Images"=>function () {
                $array_image_links = array();
                $count_images = rand(1, 10);
                for ($i = 0; $i < $count_images; $i++) {
                    array_push($array_image_links, $this->faker->imageUrl);
                }
                return $array_image_links;},
            "lawyer_id"=>Lawyer::inRandomOrder()->first->id,
        ];
    }
}
