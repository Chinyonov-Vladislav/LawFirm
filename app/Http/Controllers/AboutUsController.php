<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Instance;
use App\Models\Lawyer;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            ['link' => route('mainPage'), 'text' => 'Домашняя страница'],
            ['link'=>route('aboutUs'),'text'=>"О нас"]
        ];

        $common_count_instances = Instance::count();
        $winner_instances = Instance::where("status",'=','Выиграно')->count();
        $count_lawyers = Lawyer::count();
        $count_clients = Client::count();
        return view("pages.AboutUsPage", compact("breadcrumbs", 'common_count_instances','winner_instances',
        'count_lawyers', 'count_clients'));
    }
}
