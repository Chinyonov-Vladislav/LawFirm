<?php

namespace Database\Seeders;

use App\Models\TypeOutcome;
use Illuminate\Database\Seeder;

class TypeOutcomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypeOutcome::factory()->count(5)->create();
    }
}
