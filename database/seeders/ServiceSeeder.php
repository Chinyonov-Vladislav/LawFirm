<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Service::factory()->count(5)->create();
        $services = [
            ['name'=>"Разводы и раздел имущества",'specialization_id'=>2],
            ['name'=>"Возмещение морального и материального вреда",'specialization_id'=>1],
            ['name'=>"Защита данных и конфиденциальности",'specialization_id'=>3],
            ['name'=>"Защита прав обвиняемого",'specialization_id'=>4],
            ['name'=>"Помощь при аресте и следствии",'specialization_id'=>4],
            ['name'=>"Экспертное исследование",'specialization_id'=>4],
        ];
        foreach ($services as $service)
        {
            Service::create([
                'name' => $service['name'],
                'specialization_id' => $service['specialization_id']
            ]);
        }
    }
}
