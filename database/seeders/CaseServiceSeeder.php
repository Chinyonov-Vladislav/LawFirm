<?php

namespace Database\Seeders;

use App\Models\CaseService;
use Illuminate\Database\Seeder;

class CaseServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CaseService::factory()->count(5)->create();
    }
}
