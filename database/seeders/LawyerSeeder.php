<?php

namespace Database\Seeders;

use App\Models\Lawyer;
use Illuminate\Database\Seeder;

class LawyerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Lawyer::factory()->count(5)->create();
    }
}
