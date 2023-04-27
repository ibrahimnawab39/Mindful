<?php

use App\Http\Controllers\Front\AllController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Proxy;

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

Route::get('/start-node-server', function () {
    $command = base_path().'/server.js';

    exec($command, $output, $status);


    if ($status !== 0) {
        // handle error
        
    }

    return response()->json(["status"=>$status,"message"=>'Node.js server started']);
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Front Controller 

Route::get('/',[AllController::class,'welcome'])->name('front.welcome');
Route::get('/dashboard',[AllController::class,'dashboard'])->name('front.main');
Route::get('/get-started',[AllController::class,'settings'])->name('front.get-started');
Route::post('/get-started/store',[AllController::class,'store'])->name('front.get-started-store');
Route::get('/settings',[AllController::class,'settings'])->name('front.settings');
Route::get('/video',[AllController::class,'video'])->name('front.video');
Route::post('/connect-with',[AllController::class,'connect_with'])->name('front.connect-with');
Route::post('/change-status',[AllController::class,'change_status'])->name('front.change-status');
Route::post('/skip',[AllController::class,'skipping'])->name('front.skipping');
Route::get('/testing',function(){
    return view("testing"); 
});

Route::any('/node/{path?}', function ($path = '') {
    return app(ProxyMiddleware::class)->handle(
        request(), 
        function () {},
        'http://localhost:3000' // replace with your Node.js server's base URL
    );
})->where('path', '.*');
