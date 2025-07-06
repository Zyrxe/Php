<?php
$config = require 'config.php';
require 'telegram-handler.php';

// Ambil data JSON dari WhatsApp
$data = json_decode(file_get_contents('php://input'), true);

// Simpan log ke file (debugging)
if (!file_exists('logs')) mkdir('logs');
file_put_contents('logs/webhook.log', json_encode($data, JSON_PRETTY_PRINT) . PHP_EOL, FILE_APPEND);

// Validasi apakah ada pesan masuk
if (!isset($data['entry'][0]['changes'][0]['value']['messages'][0])) {
    exit("No new message.");
}

$message = $data['entry'][0]['changes'][0]['value']['messages'][0];
$sender = $message['from'];
$text = $message['text']['body'];

// Kirim ke Telegram
sendToTelegram("📩 Pesan baru dari WhatsApp:\nNomor: $sender\nPesan: $text");

// Kirim balasan awal ke WhatsApp
replyToWhatsApp($sender, "Halo! Terima kasih telah menghubungi kami.\n\nSilakan tuliskan negara Anda.");
