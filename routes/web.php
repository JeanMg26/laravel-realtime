<?php

use App\Http\Controllers\ChatController;
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

Route::get('/', function () {
   return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::view('users', 'users.show');
Route::view('game', 'game.show');
Route::get('chat', [ChatController::class, 'showChat']);
Route::post('chat/message', [ChatController::class, 'messageRecieved']);
Route::post('chat/greet/{user}', [ChatController::class, 'greetRecieved']);
// Route::post('chat/mensajes/{user}', [ChatController::class, 'mensajesRecieved']);
