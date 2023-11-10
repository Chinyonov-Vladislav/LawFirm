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
        //Instance::factory()->count(5)->create();
        $instances = [
            ['start_date'=>"2023-10-26",'end_date'=>null,'status'=>"В процессе",'feedback'=>null,'rating'=>null,'request_id'=>1]
        ];
        foreach ($instances as $instance)
        {
            Instance::create([
                'start_date' => $instance['start_date'],
                'end_date' => $instance['end_date'],
                'status' => $instance['status'],
                'feedback' => $instance['feedback'],
                'rating' => $instance['rating'],
                'request_id' => $instance['request_id'],
            ]);
        }
    }
}
