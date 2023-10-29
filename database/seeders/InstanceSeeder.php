<?php

namespace Database\Seeders;

use App\Models\Instance;
use Illuminate\Database\Seeder;

class InstanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Instance::factory()->count(5)->create();
    }
}
