<?php

namespace Database\Seeders;

use App\Models\Request;
use Illuminate\Database\Seeder;

class RequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Request::factory()->count(5)->create();
        $requests = [
            ['topic'=>"Тема №1",'description'=>"Проблема", 'date_request'=>"2023-10-23",'status'=>"Принято",'client_id'=>1],
            ['topic'=>"Тема №3",'description'=>"Проблема", 'date_request'=>"2023-10-25",'status'=>"В рассмотрении",'client_id'=>1]
        ];
        foreach ($requests as $request)
        {
            Request::create([
                'topic' => $request['topic'],
                'description' => $request['description'],
                'date_request' => $request['date_request'],
                'status' => $request['status'],
                'client_id' => $request['client_id'],
            ]);
        }
    }
}
