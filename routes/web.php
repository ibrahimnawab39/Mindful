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
Route::get("/optimize",function (){
   Artisan::call('optimize', ['--quiet' => true]); 
    return "Optimize Successfully!";
});
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
Route::get('/text',[AllController::class,'text'])->name('front.text');
Route::post('/connect-with',[AllController::class,'connect_with'])->name('front.connect-with');
Route::post('/change-status',[AllController::class,'change_status'])->name('front.change-status');
Route::post('/change-intrest',[AllController::class,'change_intrest'])->name('front.change-intrest');
Route::post('/skip',[AllController::class,'skipping'])->name('front.skipping');
Route::get('/testing',function(){
    return view("testing"); 
});