<?php

use App\Http\Controllers\Front\AllController;
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

Route::get('/meeting/{username}/{useremail}/{mid}', function ($username,$useremail,$mid) {
    return view("meeting",compact("mid",'username','useremail'));
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Front Controller 

Route::get('/',[AllController::class,'welcome'])->name('front.welcome');
Route::get('/dashboard',[AllController::class,'dashboard'])->name('front.main');
Route::get('/get-started',[AllController::class,'settings'])->name('front.get-started');
Route::post('/get-started/store',[AllController::class,'store'])->name('front.get-started-store');
Route::get('/settings',[AllController::class,'settings'])->name('front.settings');
Route::get('/video',[AllController::class,'video'])->name('front.video');
Route::get('/testing',function(){
    return view("testing"); 
});