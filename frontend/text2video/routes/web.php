<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
route::get('test', [VideoController::class, 'test']);

route::get('/', [VideoController::class, 'home'])->name('home');

route::get('/upload', [VideoController::class, 'showUploadForm'])->name('upload.form');

route::post('/upload', [VideoController::class, 'upload'])->name('upload');

route::get('getdata', [VideoController::class, 'getdata'])->name('getdata');

Route::get('senddata', function (){
    abort(404);
});
route::post('senddata', [VideoController::class, 'senddata'])->name('senddata');

