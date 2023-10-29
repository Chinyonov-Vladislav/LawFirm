<?php

namespace Database\Seeders;

use App\Models\ServiceLawyer;
use Illuminate\Database\Seeder;

class ServiceLawyerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ServiceLawyer::factory()->count(5)->create();
    }
}
