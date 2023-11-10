<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FAQController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            ['link' => route('mainPage'), 'text' => 'Домашняя страница'],
            ['link'=>route('faq'),'text'=>"FAQ"]
        ];
        return view("pages.FAQPage", compact("breadcrumbs"));
    }
}
