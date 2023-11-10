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
        //CourtStage::factory()->count(5)->create();
        $court_stages = [
            ['name'=>'Предварительное расследование'],
            ['name'=>'Подготовительное заседание'],
            ['name'=>'Подготовка к судебному процессу'],
            ['name'=>'Судебное заседание'],
            ['name'=>'Заключительные мероприятия'],
            ['name'=>'Вынесение решения'],
            ['name'=>'Апелляция']
        ];
        foreach ($court_stages as $court_stage)
        {
            CourtStage::create([
                'name' => $court_stage['name'],
            ]);
        }
    }
}
