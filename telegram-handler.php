<?php

function sendToTelegram($message) {
    $config = require 'config.php';
    $url = "https://api.telegram.org/bot{$config['telegram_token']}/sendMessage";

    $params = [
        'chat_id' => $config['telegram_chat_id'],
        'text' => $message
    ];

    file_get_contents($url . '?' . http_build_query($params));
}

function replyToWhatsApp($to, $message) {
    $config = require 'config.php';

    $url = "https://graph.facebook.com/v18.0/{$config['whatsapp_phone_id']}/messages";
    $payload = [
        'messaging_product' => 'whatsapp',
        'to' => $to,
        'type' => 'text',
        'text' => ['body' => $message],
    ];

    $headers = [
        "Authorization: Bearer {$config['whatsapp_token']}",
        "Content-Type: application/json"
    ];

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => json_encode($payload),
    ]);
    $result = curl_exec($ch);
    curl_close($ch);
}
