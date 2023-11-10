<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Position::factory()->count(5)->create();
        $positions = [
            ["name"=>"Судьи окружного уровня",],
            ["name"=>"Судьи апелляционного уровня",],
            ["name"=>"Судьи верховного суда",],
        ];
        foreach ($positions as $position)
        {
            Position::create([
                'name' => $position['name'],
            ]);
        }
    }
}
