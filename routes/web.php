<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;

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

//Article

Route::resource('/article', ArticleController::class)->middleware('auth:sanctum');

//Comments

Route::middleware('auth')->group(function() {
    Route::post('/comment/store', [CommentController::class, 'store'])->name('comment.store');
	// Route::get('/', 'index')->name('comment.index');
	Route::get('/comment', [CommentController::class, 'index'])->name('comment.index');
    
    Route::get('/comment/{comment}/edit', [CommentController::class, 'edit'])->name('comment.edit');
    Route::put('/comment/{comment}', [CommentController::class, 'update'])->name('comment.update');
    Route::delete('/comment/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');

	Route::get('/comment/accept/{comment}', [CommentController::class, 'accept']);
    Route::get('/comment/reject/{comment}', [CommentController::class, 'reject']);
});

//Auth
Route::get('/auth/signin', [AuthController::class, 'signIn']);

Route::get('/auth/login', [AuthController::class, 'login'])->name('login');

Route::post('/auth/registr', [AuthController::class, 'registr']);

Route::post('/auth/authenticate', [AuthController::class, 'authenticate']);

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


// Main
Route::get('/', [MainController::class, 'index']);
Route::get('/full_image/{img}', [MainController::class, 'show']);

Route::get('/about', function () {
    return view('main/about');
});
Route::get('/contacts', function () {
    
	$array = [
		'name' => 'Daniil Kolotygin',
		'address' => 'Moscow-City',
		'email' => 'daniil.kolotygyn856@gmail.com',
		'phone' => '8(951)627-56-20',
	];

	return view('main/contacts', ['contacts' => $array]);
});
