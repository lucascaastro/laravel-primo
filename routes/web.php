<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Jobs\ConvertCelsius;
use App\Jobs\FindMaxPrime;
use App\Jobs\MakeDiv;

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

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/signin', [AuthController::class, 'signin'])->name('signin');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware('auth');

Route::get('/primo/{limit}', function ($limit) {
    FindMaxPrime::dispatch($limit, auth()->id());

    return 'O cálculo será realizado em fila';
});

Route::get('/notifications', function () {
    $user = auth()->user();

    foreach ($user->unreadnotifications as $noti) {
        echo '<h3>' . $noti->data['description'] . '</h3>';
    }
});

Route::get('/celsius/{farenheit}', function ($farenheit) {
    ConvertCelsius::dispatch($farenheit, auth()->id());

    return 'O cálculo será realizado em fila';
});

Route::get('/make/div/{num1}/{num2}', function ($num1, $num2) {
    MakeDiv::dispatch($num1, $num2, auth()->id());

    return 'O cálculo será realizado em fila';
});