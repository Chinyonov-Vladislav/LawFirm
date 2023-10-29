<?php

namespace Database\Seeders;

use App\Models\Outcome;
use Illuminate\Database\Seeder;

class OutcomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Outcome::factory()->count(5)->create();
    }
}
