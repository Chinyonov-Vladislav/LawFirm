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
        //Lawyer::factory()->count(5)->create();

        $lawyers = [
            [
                "first_name"=>"Егор",
                "second_name"=>"Игнатов",
                'middle_name'=>"Николаевич",
                'hire_date'=>"1990-08-23",
                'images'=>"[\"/photos/logo.png\"]",
                'number_phone'=>"79493278574",
                'university_id'=>1,
                'user_id'=>3,
                'level_education'=>"Бакалавр"],
        ];
        foreach ($lawyers as $lawyer)
        {
            Lawyer::create([
                'first_name' => $lawyer['first_name'],
                'second_name' => $lawyer['second_name'],
                'middle_name' => $lawyer['middle_name'],
                'hire_date' => $lawyer['hire_date'],
                'images' => $lawyer['images'],
                'number_phone' => $lawyer['number_phone'],
                'university_id' => $lawyer['university_id'],
                'user_id' => $lawyer['user_id'],
                'level_education' => $lawyer['level_education'],
            ]);
        }
    }
}
