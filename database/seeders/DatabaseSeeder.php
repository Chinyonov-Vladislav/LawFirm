<?php

namespace Database\Seeders;

use App\Models\CourtStage;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // может быть добавить user
            CitySeeder::class,
            CourtSeeder::class,
            PositionSeeder::class,
            JudgeSeeder::class,
            CourtStageSeeder::class,
            SpecializationSeeder::class,
            ServiceSeeder::class,
            UniversitySeeder::class,
            LawyerSeeder::class,
            NewsSeeder::class,
            ServiceLawyerSeeder::class,
            ClientSeeder::class,
            RequestSeeder::class,
            TypeOutcomeSeeder::class,
            OutcomeSeeder::class,
            InstanceSeeder::class,
            CaseProceedingSeeder::class,
            CaseServiceSeeder::class
        ]);
    }
}
