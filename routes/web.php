<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DocxController;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\InstanceController;
use App\Http\Controllers\LawyerController;
use App\Http\Controllers\MainPageController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SpecializationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use TCG\Voyager\Facades\Voyager;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();
Route::get('/', [MainPageController::class, "index"])->name("mainPage");
Route::post("/checkAuthUser",[AuthController::class, 'checkAuthUser'])->name("checkAuthUser");
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post("/getSpecializations", [SpecializationController::class, "getSpecialization"])->name("getAllSpecialization");
Route::get("/aboutUs",[AboutUsController::class,"index"])->name("aboutUs");
Route::get("/faq",[FAQController::class, "index"])->name("faq");
Route::get("/blog",[BlogController::class, "index"])->name("blog");
Route::get("/news/{id}",[BlogController::class, "showNews"])->name("showNews");
Route::get("/specializations",[SpecializationController::class,'showAllSpecializationsPage'])->name("showAllSpecializationsPage");
Route::get("/specialization/{id}",[SpecializationController::class, "showSpecializationPage"])->name("showSpecializationPage");
Route::get("/lawyers",[LawyerController::class, "getAllLawyers"])->name("getAllLawyers");
Route::get("/lawyer/{id}",[LawyerController::class, "getLawyerPage"])->name("getLawyerPage");
Route::get("/services",[ServiceController::class, 'getServices'] )->name("getServices");
Route::get("/reviews",[ReviewsController::class, "getReviews"])->name("getReviews");
Route::middleware("guest")->group(function(){
    Route::get("/restorePassword",[AuthController::class, 'restorePassword'])->name("restorePassword");
    Route::post("/restorePassword",[AuthController::class,'resetPassword'])->name("resetPassword");
    Route::get("/restorePassword/{token}",[AuthController::class, "showPageChangePassword"])->name("showPageChangePassword");
    Route::put("/restorePassword",[AuthController::class,'updatePasswordUser'])->name("updatePasswordUser");
});
Route::middleware("auth")->group(function () {
    Route::get("docx/export-services-lawyer/{id}", [DocxController::class, 'downloadServices'])->where('id', '[0-9]+')->name("downloadServices");
    Route::get("docx/export-instances-lawyer/{id}", [DocxController::class, 'downloadInstances'])->where('id', '[0-9]+')->name("downloadInstances");
    Route::get('excel/export-specializations-lawyer/{id}',[UserController::class,'exportSpecializations'])->where('id', '[0-9]+')->name('export-specializations-lawyer');
    Route::get('excel/export-instances-lawyer/{id}',[UserController::class,'exportInstances'])->where('id', '[0-9]+')->name('export-instances-lawyer');
    Route::post("/updateDataUser",[UserController::class, "updateDataUser"])->name("updateDataUser");
    Route::get("/user/{id}", [UserController::class,"getPersonalAccount"])->where('id', '[0-9]+')->name("getPersonalAccount");
    Route::post("/save_info_client", [UserController::class, 'saveInfoClient'])->name("saveInfoClient");
    Route::post("/createRequest", [RequestController::class,"createRequest"])->name("createRequest");
    Route::delete("/deleteRequest/{id}",[RequestController::class, "deleteRequest"])->where('id', '[0-9]+')->name("deleteRequest");
    Route::put("/updateImageLawyer",[UserController::class, 'updateImageLawyer'])->name("updateImageLawyer");
    Route::put("/redactRequest",[RequestController::class, 'redactRequest'])->name("redactRequest");
    Route::put("/saveNewInfoLawyer",[UserController::class, 'updateDataInfoLawyer'])->name("updateDataInfoLawyer");
    Route::get("/infoInstance/{id}",[InstanceController::class, "showInfoInstance"])->name("infoInstance");
    Route::put("/changeNews",[BlogController::class, "changeNews"])->name("changeNews");
    Route::post("/loadImage", [ImageController::class, "loadImages"])->name("loadImages");
    Route::post("/createNews",[BlogController::class, 'createNews'])->name("createNews");
    Route::delete("/deleteNews/{id}",[BlogController::class, "deleteNews"])->where('id', '[0-9]+')->name("deleteNews");
    Route::put("/saveFeedback", [InstanceController::class, "saveFeedback"])->name("saveFeedback");
    Route::delete("/deleteFeedback/{id}",[InstanceController::class, "deleteFeedback"])->where('id', '[0-9]+')->name("deleteFeedback");
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
