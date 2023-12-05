<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\MailController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutControllerIzan;
use App\Http\Controllers\AboutControllerAdria;
use App\Http\Controllers\AboutController;


use Illuminate\Support\Facades\Log;

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

Route::get('/', function () {
    return view('home');
});

Route::get('/', function (Request $request) {
    $message = 'Loading welcome page';
    Log::info($message);
    $request->session()->flash('info', $message);
    return view('home');
 });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('mail/test', [MailController::class, 'test']);
// or
// Route::get('mail/test', 'App\Http\Controllers\MailController@test');

Route::resource('files', FileController::class)->middleware('auth');
Route::resource('places', PlaceController::class)->middleware('auth');
Route::resource('posts', PostController::class)->middleware('auth');

Route::post('/posts/{post}/like', [PostController::class, 'like'])->name('posts.like');
Route::get('/language/{locale}', [LanguageController::class,'language'])->name('language');

Route::post('/places/{place}/favs', [PlaceController::class, 'favorite'])->name('places.favorite');

Route::put('/places/{place}', function (Place $place) {
})->middleware('can:favorite,place');

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/about-izan', [AboutControllerIzan::class, 'about'])->name('about-izan');
Route::get('/about-adria', [AboutControllerAdria::class, 'about'])->name('about-adria');
Route::get('/about', [AboutController::class, 'about'])->name('about');


require __DIR__.'/auth.php';
