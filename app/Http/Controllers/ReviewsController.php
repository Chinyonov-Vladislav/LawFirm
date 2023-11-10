<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewsController extends Controller
{
    public function getReviews()
    {
        $breadcrumbs = [
            ['link' => route('mainPage'), 'text' => 'Домашняя страница'],
            ['link'=>route('getReviews'),'text'=>"Отзывы"]
        ];
        $reviews = DB::table("instances")
            ->join("requests",'instances.request_id','=','requests.id')
            ->join("clients",'requests.client_id','=','clients.id')
            ->whereNotNull("instances.feedback")
            ->orWhereNotNull("instances.rating")
            ->select(
                "requests.topic as topic_request",
                DB::raw("CONCAT(clients.second_name, ' ', clients.first_name, ' ', clients.middle_name) as client_full_name"),
                "instances.feedback as feedback_instance",
                "instances.rating as rating_instance",
            )->get();
        $scores = DB::table("instances")
            ->whereNotNull("rating")
            ->select("rating", DB::raw("COUNT(*) as count"))
            ->groupBy("rating")
            ->get();
        $average_rating = DB::table("instances")
            ->whereNotNull("rating")->avg("rating");
        return view("pages.reviewsPage", compact("reviews","scores",'average_rating','breadcrumbs'));
    }
}
