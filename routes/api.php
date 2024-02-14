<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatBotTwilio;
use App\Http\Controllers\ChatBotTelegram;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
curl -X POST \
  -d "message=Hola&recipient=0995819939" \
  "http://localhost:8000/api/chat-send"

  https://www.twilio.com/es-mx/blog/crear-un-chatbot-de-whatsapp-con-la-api-de-whatsapp-de-twilio-php-y-laravel
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/chat-bot', [ChatBotTwilio::class, 'handleWebhook']);
Route::post('/chat-send', [ChatBotTwilio::class, 'sendWhatsAppMessage']);

Route::post('/action', function(Request $request) {
  $request->telegramWebAppUser('id'); // ID of telegram user
})->middleware('telebot-webapp');

Route::post('/webhook/telegram', [ChatBotTelegram::class,'handle']);
Route::get('/index-telegram', [ChatBotTelegram::class, 'index']);
Route::post('/send-telegram', [ChatBotTelegram::class, 'sendMessage']);