# Php

# 📲 Webhook WhatsApp ke Telegram Bot (PHP)

Sistem ini menerima pesan dari WhatsApp Business API dan meneruskannya ke Bot Telegram. Webhook juga dapat mengirim balasan otomatis ke WhatsApp.

## 🚀 Fitur
- Terima pesan masuk dari WhatsApp API
- Kirim pesan tersebut ke Telegram
- Kirim balasan otomatis ke pengirim WhatsApp

## 📁 Struktur File
- `whatsapp-webhook.php`: Endpoint webhook untuk WhatsApp
- `telegram-handler.php`: Fungsi untuk kirim pesan ke Telegram dan balas ke WhatsApp
- `config.php`: Tempat menyimpan token API
- `logs/webhook.log`: Log pesan masuk dari WhatsApp

## 🛠️ Cara Menjalankan

1. Hosting file di server dengan PHP (bisa pakai 000webhost / VPS)
2. Buat bot Telegram dan ambil token serta chat ID
3. Masukkan token WhatsApp & Telegram ke `config.php`
4. Daftarkan webhook di Meta Developer Console ke:
