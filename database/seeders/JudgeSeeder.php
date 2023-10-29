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
        Judge::factory()->count(5)->create();
    }
}
