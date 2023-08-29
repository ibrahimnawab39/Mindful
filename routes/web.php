<?php

use App\Http\Controllers\Front\AllController;
use Illuminate\Support\Facades\Artisan;
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

Route::get("/optimize", function () {
    Artisan::call('optimize', ['--quiet' => true]);
    return "Optimize Successfully!";
});
Route::get('/meeting/{username}/{useremail}/{mid}', function ($username, $useremail, $mid) {
    return view("meeting", compact("mid", 'username', 'useremail'));
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Front Controller 

Route::get('/', [AllController::class, 'dashboard'])->name('front.welcome');
Route::get('/dashboard', [AllController::class, 'dashboard'])->name('front.main');

Route::get('/get-started', [AllController::class, 'settings'])->name('front.get-started');
Route::get('/get-started/{type}', [AllController::class, 'settings'])->name('front.get-started-type');
Route::get('/get-started/{type}/{meeting_id}', [AllController::class, 'settings'])->name('front.get-started-type-meeting-id');
Route::post('/get-started/store', [AllController::class, 'store'])->name('front.get-started-store');
Route::get('/settings', [AllController::class, 'settings'])->name('front.settings');
Route::get('/video', [AllController::class, 'video'])->name('front.video');
Route::get('/share-video/{meeting_id?}', [AllController::class, 'share'])->name('front.share');
Route::get('/text', [AllController::class, 'text'])->name('front.text');
Route::get('/update-status', [AllController::class, 'updateStatus'])->name('front.change-time');
Route::post('/connect-with', [AllController::class, 'connect_with'])->name('front.connect-with');
Route::post('/change-status', [AllController::class, 'change_status'])->name('front.change-status');
Route::post('/change-intrest', [AllController::class, 'change_intrest'])->name('front.change-intrest');
Route::post('/skip', [AllController::class, 'skipping'])->name('front.skipping');
Route::post('/chat-gpt', [AllController::class, 'chat_gpt'])->name('front.chat-gpt');
Route::get('/rules', [AllController::class, 'rules'])->name('front.rules');
Route::post('/report', [AllController::class, 'report'])->name('front.report');
Route::get('/blocked', [AllController::class, 'blocked'])->name('front.blocked');
Route::get('/beforeunload', [AllController::class, 'beforeunload'])->name('front.beforeunload');


Route::get('/testing', function () {
    return view("testing");
});