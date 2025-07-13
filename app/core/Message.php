<?php


namespace App\Core;

//message twilo 
class Message {
    public static function sendTwilioSms($to, $body) {
        require_once __DIR__ . '/../../vendor/autoload.php';
        $sid = $_ENV['TWILIO_SID'] ?? '';
        $token = $_ENV['TWILIO_TOKEN'] ?? '';
        $from = $_ENV['TWILIO_FROM'] ?? '';
        if (!$sid || !$token || !$from) {
            return false;
        }
        try {
            $client = new \Twilio\Rest\Client($sid, $token);
            $client->messages->create($to, [
                'from' => $from,
                'body' => $body
            ]);
            return true;
        } catch (\Exception $e) {
            // Log ou gérer l'erreur si besoin
            return false;
        }
    }
}

