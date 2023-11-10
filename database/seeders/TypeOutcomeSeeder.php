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
        //TypeOutcome::factory()->count(5)->create();
        $types_outcome = [
            ['name'=>'Денежный штраф'],
            ['name'=>'Лишение свободы'],
        ];
        foreach ($types_outcome as $type_outcome)
        {
            TypeOutcome::create([
                'name' => $type_outcome['name'],
            ]);
        }
    }
}
