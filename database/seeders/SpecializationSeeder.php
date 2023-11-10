<?php

namespace Database\Seeders;

use App\Models\Specialization;
use Illuminate\Database\Seeder;

class SpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $specializations = [
            ['name'=>"Гражданское право",'description'=>"одна из основных отраслей права, регулирующая отношения между физическими и юридическими лицами в сфере частных прав и обязанностей",'icon'=>"la-city"],
            ['name'=>"Семейное право",'description'=>"отрасль права, которая регулирует отношения внутри семьи",'icon'=>"la-users"],
            ['name'=>"Информационное право",
                'description'=>"Занимается правовыми аспектами использования и управления информацией в цифровой среде. Она охватывает широкий спектр вопросов, связанных с интернетом, компьютерными системами, цифровыми данными, электронной коммерцией и другими аспектами информационных технологий.",'icon'=>"la-broadcast-tower"],
            ['name'=>"Уголовное право",'description'=>"отрасль права, которая устанавливает нормы и стандарты, определяющие преступления, их наказание, а также процедуры расследования и судебного разбирательства в уголовных делах",'icon'=>"la-user"]
        ];
        foreach ($specializations as $specialization)
        {
            Specialization::create([
                'name' => $specialization['name'],
                'description' => $specialization['description'],
                'icon' => $specialization['icon'],
            ]);
        }
    }
}
