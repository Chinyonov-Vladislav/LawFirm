<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\MainPageController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\SpecializationContoller;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [MainPageController::class, "index"])->name("mainPage");
Auth::routes();
Route::post("/checkAuthUser",[AuthController::class, 'checkAuthUser'])->name("checkAuthUser");
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post("/getSpecializations", [SpecializationContoller::class, "getSpecialization"])->name("getAllSpecialization");
Route::get("/aboutUs",[AboutUsController::class,"index"])->name("aboutUs");
Route::get("/faq",[FAQController::class, "index"])->name("faq");
Route::get("/blog",[BlogController::class, "index"])->name("blog");
Route::middleware("auth")->group(function () {
    Route::get("/user/{id}", [UserController::class,"getPersonalAccount"])->where('id', '[0-9]+')->name("getPersonalAccount");
    Route::post("/save_info_client", [UserController::class, 'saveInfoClient'])->name("saveInfoClient");
    Route::post("/createRequest", [RequestController::class,"createRequest"])->name("createRequest");
    Route::delete("/deleteRequest/{id}",[RequestController::class, "deleteRequest"])->name("deleteRequest");
    Route::put("/redactRequest",[RequestController::class, 'redactRequest'])->name("redactRequest");
});
