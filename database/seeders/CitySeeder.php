<?php

namespace Database\Seeders;

use App\Models\City;
use Database\Factories\CityFactory;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //City::factory()->count(5)->create();
        $cities = [
            ["name"=>"Москва"],
            ["name"=>"Ростов-на-Дону"],
            ["name"=>"Воронеж"]
        ];
        foreach ($cities as $city)
        {
            City::create(['name' => $city['name']]);
        }
    }
}
