<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;
use Twilio\TwiML\MessagingResponse;

class ChatBotTwilio extends Controller
{
    /**
     * Maneja el webhook para los mensajes de WhatsApp.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function handleWebhook(Request $request)
    {
        $remitente = $request->input('From');
        $mensaje = $request->input('Body');
        $profile = $request->input('ProfileName');
        

        Log::info('Este es un mensaje de información.', $request->all());

        $response = new MessagingResponse();
        $message = $response->message('¡Manuel!'.$profile);
         
        return response($response)->header('Content-Type', 'application/xml');
    }

    /**
     * Envía un mensaje de WhatsApp utilizando Twilio.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendWhatsAppMessage(Request $request)
    {
        $twilio_sid = config('app.twilio_sid');
        $twilio_token = config('app.twilio_auth_token');
        $twilio_phone_number = config('app.twilio_phone_number');

        $client = new Client($twilio_sid, $twilio_token);

        $to = $request->input('to');
        $message = $request->input('message'); 

        $client->messages->create(
            $to,
            ['from' => $twilio_phone_number,'body' => $message]
        );

        return response()->json(['message' => 'SMS enviado']);
    }
}
