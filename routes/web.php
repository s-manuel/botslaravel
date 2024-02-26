<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatBotTelegram;

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
    return view('welcome');
});

Route::post('/telebot/webhook/bot/{token}', [ChatBotTelegram::class, 'handle']);
Route::post('/webhook/telegram', [ChatBotTelegram::class, 'handle']);
Route::get('/index-telegram', [ChatBotTelegram::class, 'index']);
Route::post('/send-telegram', [ChatBotTelegram::class, 'sendMessage']);