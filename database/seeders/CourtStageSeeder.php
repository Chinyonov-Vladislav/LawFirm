<?php

namespace Database\Seeders;

use App\Models\CourtStage;
use Illuminate\Database\Seeder;

class CourtStageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CourtStage::factory()->count(5)->create();
    }
}
