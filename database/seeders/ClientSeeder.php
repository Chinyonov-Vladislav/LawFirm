<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Client::factory()->count(5)->create();
        $clients = [
            ['first_name'=>"Игорь",
                'second_name'=>"Маслов",
                'middle_name'=>"Иванович",
                'number_phone'=>"79493785221",
                'address'=>"Железнодорожная Улица,19, Мурашинский Район",
                'birthday'=>"1978-10-24",
                'user_id'=>2,
                'city_id'=>2]
        ];
        foreach ($clients as $client)
        {
            Client::create([
                'first_name' => $client['first_name'],
                'second_name' => $client['second_name'],
                'middle_name' => $client['middle_name'],
                'number_phone' => $client['number_phone'],
                'address' => $client['address'],
                'birthday' => $client['birthday'],
                'user_id' => $client['user_id'],
                'city_id' => $client['city_id'],
            ]);
        }
    }
}
