<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use WeStacks\TeleBot\Objects\Message;
use WeStacks\TeleBot\Laravel\TeleBot;

class ChatBotTelegram extends Controller
{

    /**
     * Maneja el webhook para los mensajes de WhatsApp.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request)
    {
        # Procesar la actualización del webhook de Telegram aquí
        $update = $request->all(); # Obtener la actualización de Telegram

        Log::info('TelegramApi update');
         
        return response()->json(['status' => 'ok']);
    }

    /**
     * Maneja el webhook para los mensajes de WhatsApp.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $telegramApi = TeleBot::getMe();
        // dd($telegramApi);
        Log::info('TelegramApi.', $telegramApi);
         
        return response($telegramApi)->header('Content-Type', 'application/xml');
    }

    public function sendMessage(Request $request)
    {
        try {
            // dd(config('telebot.token'));
            // dd(env('TELEGRAM_BOT_TOKEN'));
            // Crear una instancia de TeleBot con tu token de bot
            $message = TeleBot::sendMessage([
                'chat_id' => '1390360169', // ID del chat al que quieres enviar el mensaje
                'text' => 'Este es un mensaje de prueba desde Laravel.',
            ]);

            // Puedes hacer lo que necesites con la respuesta aquí, como loguearla o manejarla de alguna manera
            // Por ejemplo, podrías devolver la respuesta en una vista o en formato JSON
            return response()->json($message);
        } catch (TeleBotRequestException $e) {
            // Manejar errores de solicitud (por ejemplo, error de autenticación)
            return response()->json(['error' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            // Manejar cualquier otra excepción
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
