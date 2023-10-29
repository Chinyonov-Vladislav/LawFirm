<?php

namespace Database\Seeders;

use App\Models\CaseProceeding;
use Illuminate\Database\Seeder;

class CaseProceedingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CaseProceeding::factory()->count(5)->create();
    }
}
