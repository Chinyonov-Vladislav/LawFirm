<?php

namespace App\Http\Controllers;

use App\Models\Lawyer;
use App\Models\News;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $breadcrumbs = [
            ['link' => route('mainPage'), 'text' => 'Домашняя страница'],
            ['link'=>route('blog'),'text'=>"Блог"]
        ];
        $all_count_news = News::all()->count();
        $news_query = News::with("Lawyer");
        if($request->has("searchText"))
        {
            if($request->has("option1"))
            {
                if(filter_var( $request->query('option1'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE )) {
                    $news_query->where('title', 'LIKE', '%' . $request->query("searchText") . '%');
                }
            }
            if($request->has("option2") && $request->query("option2"))
            {
                if(filter_var( $request->query('option2'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE )) {
                    $news_query->where('description', 'LIKE', '%' . $request->query("searchText") . '%');
                }
            }
        }
        $news = $news_query->get();
        return view("pages.blogPage",compact('news','breadcrumbs','all_count_news'));
    }
    public function createNews(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'images_paths' => ["present", "array"],
                'title' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string', 'max:5000'],
            ]);
            if($validator->fails())
            {
                return response()->json(['errors'=>$validator->errors()]);
            }
            $current_user_id = Auth::id();
            $lawyer = Lawyer::where('user_id', '=',$current_user_id)->first();
            if($lawyer == null)
            {
                return response()->json(['success'=>false, 'message'=>"Только адвокаты могут публиковать новости"]);
            }
            $new_article = new News();
            $new_article->title = $request->title;
            $new_article->description = $request->description;
            $new_article->images = $request->images_paths;
            $new_article->lawyer_id = $lawyer->id;
            $new_article->save();
            return response()->json(['success'=>true,'message'=>"Новая новость была успешно создана", 'new_article'=>$new_article]);
        }
        catch (Exception $exception)
        {
            return response()->json(['success'=>false, "message"=>$exception->getMessage()]);
        }
    }
    public function showNews($id)
    {

        $current_article = News::with("Lawyer.user")->findOrFail($id);
        //$current_article->description =nl2br($current_article->description, false);
        //$current_article->description =nl2br($current_article->description, false);
        $id_auth_user = Auth::id();
        $can_redact = $id_auth_user == $current_article->lawyer->user_id;
        $breadcrumbs = [
            ['link' => route('mainPage'), 'text' => 'Домашняя страница'],
            ['link'=>route('blog'),'text'=>"Блог"],
            ['link'=>route('showNews', $id),'text'=>"Новость №".$current_article->id]
        ];
        return view("pages.ArticlePage",compact('current_article', 'can_redact','breadcrumbs'));
    }
    public function changeNews(Request $request): JsonResponse
    {
        try {
            $current_user_id = Auth::id();
            $current_article_users_id = $request->article['lawyer']['user_id'];
            if ($current_article_users_id != $current_user_id) {
                return response()->json(['success' => false, 'message' => "Авторизованный пользователь не является автором статьи"]);
            }
            $article = News::find($request->article['id']);
            if ($article == null) {
                return response()->json(['success' => false, "message" => "Новость не была найдена"]);
            }
            $article->title = $request->article['title'];
            $article->description = $request->article['description'];
            $article_images_from_request = $request->article['images'];
            $new_images_for_article = $request->images_paths;
            $result_images = array();
            logger($article->image);
            foreach ($article_images_from_request as $image) {
                if (file_exists(public_path() . $image)) {
                    array_push($result_images, $image);
                }
            }
            foreach ($new_images_for_article as $image)
            {
                if(file_exists(public_path().$image))
                {
                    array_push($result_images, $image);
                }
            }
            $article->images = $result_images;
            $article->save();
            return response()->json(['success'=>true, "message"=>"Новость успешно обновлена"]);
        }
        catch(Exception $exception)
        {
            return response()->json(['success'=>false, "message"=>$exception->getMessage()]);
        }
    }
    public function deleteNews($id)
    {
        $current_article = News::with("Lawyer.user")->first();
        if($current_article == null)
        {
            return response()->json(['success'=>false, 'message'=>"Новость с ".$id." не была найдена"]);
        }
        $auth_user_id = Auth::id();
        if($auth_user_id != $current_article->lawyer->user_id)
        {
            return response()->json(["success"=>false, "message"=>"Вы не являетесь автором новости с id = ".$id]);
        }
        News::where("id",'=',$id)->delete();
        return response()->json(['success'=>true, 'message'=>"Новость №".$id." была успешно удалена"]);
    }
}
