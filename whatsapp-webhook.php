<?php
// Load konfigurasi token dari config.php
$config = include 'config.php';

$verify_token = 'verif-wabot-2025'; // ✅ Token verifikasi kamu (bebas tentukan, harus sama di Meta)

// === VERIFIKASI WEBHOOK (GET) ===
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['hub_verify_token'])) {
    if ($_GET['hub_verify_token'] === $verify_token) {
        echo $_GET['hub_challenge'];
        exit;
    } else {
        echo "Token verifikasi salah.";
        exit;
    }
}

// === HANDLE PESAN MASUK DARI WHATSAPP (POST) ===
$input = file_get_contents("php://input");
file_put_contents("logs/webhook.log", $input . PHP_EOL, FILE_APPEND); // log pesan

$data = json_decode($input, true);

if (isset($data['entry'][0]['changes'][0]['value']['messages'][0])) {
    $message = $data['entry'][0]['changes'][0]['value']['messages'][0];
    $from = $message['from']; // Nomor pengirim
    $text = $message['text']['body']; // Isi pesan

    // Kirim pesan ke Telegram
    $telegramMessage = "📩 *Pesan WhatsApp Masuk*\n\n👤 *Dari*: $from\n💬 *Pesan*: $text";
    sendToTelegram($telegramMessage, $config['telegram_token'], $config['telegram_chat_id']);

    // Balas otomatis ke WhatsApp
    sendWhatsAppReply($from, "Halo! Terima kasih telah menghubungi kami. 🌐 Silakan tuliskan negara Anda.", $config);
}

function sendToTelegram($text, $token, $chat_id) {
    $url = "https://api.telegram.org/bot$token/sendMessage";
    $data = [
        'chat_id' => $chat_id,
        'text' => $text,
        'parse_mode' => 'Markdown'
    ];
    file_get_contents($url . '?' . http_build_query($data));
}

function sendWhatsAppReply($to, $message, $config) {
    $url = "https://graph.facebook.com/v19.0/{$config['whatsapp_phone_id']}/messages";
    $data = [
        'messaging_product' => 'whatsapp',
        'to' => $to,
        'type' => 'text',
        'text' => ['body' => $message]
    ];
    $headers = [
        "Authorization: Bearer {$config['whatsapp_token']}",
        'Content-Type: application/json'
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);
}
