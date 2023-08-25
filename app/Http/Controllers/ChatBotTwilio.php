<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Twilio\Rest\Client;

class ChatBotTwilio extends Controller
{
    /**
     * Procesarán los mensajes enviados a su número de WhatsApp
     */
    public function listenToReplies(Request $request)
    {
        $from = $request->input('From');
        $body = $request->input('Body');

        $client = new \GuzzleHttp\Client();
        try {
            $response = $client->request('GET', "https://api.github.com/users/$body");
            $githubResponse = json_decode($response->getBody());
            if ($response->getStatusCode() == 200) {
                $message = "*Name:* $githubResponse->name\n";
                $message .= "*Bio:* $githubResponse->bio\n";
                $message .= "*Lives in:* $githubResponse->location\n";
                $message .= "*Number of Repos:* $githubResponse->public_repos\n";
                $message .= "*Followers:* $githubResponse->followers devs\n";
                $message .= "*Following:* $githubResponse->following devs\n";
                $message .= "*URL:* $githubResponse->html_url\n";
                $this->sendWhatsAppMessage($message, $from);
            } else {
                $this->sendWhatsAppMessage($githubResponse->message, $from);
            }
        } catch (RequestException $th) {
            $response = json_decode($th->getResponse()->getBody());
            $this->sendWhatsAppMessage($response->message, $from);
        }
        return;
    }

    /**
     * Sends a WhatsApp message  to user using
     * @param string $message Body of sms
     * @param string $recipient Number of recipient
     */
    public function sendWhatsAppMessage(Request $request)
    {
        $twilio_sid = config('app.twilio_sid');
        $twilio_token = config('app.twilio_auth_token');
        $twilio_phone_number = config('app.twilio_phone_number');

        // echo 'twilio_sid -> '. $twilio_sid . '\n';
        // echo 'twilio_sid -> '.$twilio_token;
        // echo 'twilio_phone_number -> '.$twilio_phone_number;

        $client = new Client($twilio_sid, $twilio_token);

        // +593995819939
        // +593986089903

        $to = $request->input('to');
        // echo 'to ->'.$to. '\n';
        $message = $request->input('message'); 

        $client->messages->create(
            $to,
            [
                'from' => $twilio_phone_number,
                'body' => $message,
            ]
        );

        return response()->json(['message' => 'SMS enviado']);
    }
}
