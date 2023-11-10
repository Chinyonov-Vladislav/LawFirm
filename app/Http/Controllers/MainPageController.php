<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Instance;
use App\Models\Lawyer;
use App\Models\News;
use App\Models\Specialization;
use Illuminate\Http\Request;

class MainPageController extends Controller
{
    private $specializations;
    private $news;
    public function __construct()
    {
        $this->news = new News();
        $this->specializations = new Specialization();
    }

    public function index()
    {
        $specializations = $this->specializations->getAllSpecializations();
        $common_count_instances = Instance::count();
        $winner_instances = Instance::where("status",'=','Выиграно')->count();
        $count_lawyers = Lawyer::count();
        $count_clients = Client::count();
        $news = News::with("Lawyer")->latest()->take(3)->get();
        return view('pages.mainPage',compact("specializations", "news",
            'common_count_instances','winner_instances','count_lawyers','count_clients'));
    }
}
