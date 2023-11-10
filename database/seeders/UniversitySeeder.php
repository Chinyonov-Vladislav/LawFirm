<?php

namespace Database\Seeders;

use App\Models\University;
use Illuminate\Database\Seeder;

class UniversitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //University::factory()->count(5)->create();
        $universities = [
            ["name"=>"Московский государственный юридический университет имени О.Е. Кутафина (МГЮА)","city_id"=>1],
            ["name"=>"Южный федеральный университет (ЮФУ), Юридический институт","city_id"=>2],
            ["name"=>"Воронежский государственный университет (ВГУ), Юридический факультет","city_id"=>3],
        ];
        foreach ($universities as $university)
        {
            University::create([
                'name' => $university['name'],
                'city_id' => $university['city_id']
            ]);
        }
    }
}
