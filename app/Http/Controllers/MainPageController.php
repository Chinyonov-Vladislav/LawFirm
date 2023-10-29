<?php

namespace App\Http\Controllers;

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
        $news = $this->news->getLastThreeNews();
        $specializations = $this->specializations->getAllSpecializations();
        return view('pages.mainPage',compact("specializations", "news"));
    }
}
