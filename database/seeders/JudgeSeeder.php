<?php

namespace Database\Seeders;

use App\Models\Judge;
use Illuminate\Database\Seeder;


class JudgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $judges = [
            ['first_name'=>"Иван",'second_name'=>"Иванов", "middle_name"=>"Иванович",'position_id'=>1,'court_id'=>1],
            ['first_name'=>"Людмила",'second_name'=>"Зыкова", "middle_name"=>"Ильинична",'position_id'=>2,'court_id'=>2],
            ['first_name'=>"Иван",'second_name'=>"Давыдов", "middle_name"=>"Александрович",'position_id'=>3,'court_id'=>3],
        ];
        foreach ($judges as $judge)
        {
            Judge::create([
                'first_name' => $judge['first_name'],
                'second_name' => $judge['second_name'],
                'middle_name' => $judge['middle_name'],
                'position_id' => $judge['position_id'],
                'court_id' => $judge['court_id'],
            ]);
        }
    }
}
