<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

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
