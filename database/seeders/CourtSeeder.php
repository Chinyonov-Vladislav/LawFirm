<?php

namespace Database\Seeders;

use App\Models\Court;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CourtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        //Court::factory()->count(5)->create();
        $courts = [
            ["name_court"=>$faker->company, 'address'=>$faker->address, 'number_phone'=>$faker->phoneNumber,'city_id'=>1],
            ["name_court"=>$faker->company, 'address'=>$faker->address, 'number_phone'=>$faker->phoneNumber,'city_id'=>2],
            ["name_court"=>$faker->company, 'address'=>$faker->address, 'number_phone'=>$faker->phoneNumber,'city_id'=>3],
        ];
        foreach ($courts as $court)
        {
            Court::create([
                'name_court' => $court['name_court'],
                'address'=>$court['address'],
                'number_phone'=>$court['number_phone'],
                'city_id'=>$court['city_id']
            ]);
        }
    }
}
