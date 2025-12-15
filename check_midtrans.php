<?php

// Script untuk cek konfigurasi Midtrans
echo "=== CEK KONFIGURASI MIDTRANS ===\n\n";

// Cek .env file
$envPath = __DIR__ . '/.env';
if (!file_exists($envPath)) {
    echo "❌ File .env tidak ditemukan!\n";
    exit(1);
}

$envContent = file_get_contents($envPath);

// Cek Midtrans Server Key
if (preg_match('/MIDTRANS_SERVER_KEY=(.+)/', $envContent, $matches)) {
    $serverKey = trim($matches[1]);
    if (empty($serverKey) || $serverKey === 'your-server-key') {
        echo "❌ MIDTRANS_SERVER_KEY belum diisi!\n";
        echo "   Isi dengan Server Key dari Midtrans Dashboard\n\n";
    } else {
        echo "✅ MIDTRANS_SERVER_KEY: " . substr($serverKey, 0, 10) . "...\n";
    }
} else {
    echo "❌ MIDTRANS_SERVER_KEY tidak ditemukan di .env\n";
    echo "   Tambahkan: MIDTRANS_SERVER_KEY=your-server-key\n\n";
}

// Cek Midtrans Client Key
if (preg_match('/MIDTRANS_CLIENT_KEY=(.+)/', $envContent, $matches)) {
    $clientKey = trim($matches[1]);
    if (empty($clientKey) || $clientKey === 'your-client-key') {
        echo "❌ MIDTRANS_CLIENT_KEY belum diisi!\n";
        echo "   Isi dengan Client Key dari Midtrans Dashboard\n\n";
    } else {
        echo "✅ MIDTRANS_CLIENT_KEY: " . substr($clientKey, 0, 10) . "...\n";
    }
} else {
    echo "❌ MIDTRANS_CLIENT_KEY tidak ditemukan di .env\n";
    echo "   Tambahkan: MIDTRANS_CLIENT_KEY=your-client-key\n\n";
}

// Cek Midtrans Environment
if (preg_match('/MIDTRANS_IS_PRODUCTION=(.+)/', $envContent, $matches)) {
    $isProduction = trim($matches[1]);
    echo "✅ MIDTRANS_IS_PRODUCTION: " . $isProduction . "\n";
} else {
    echo "⚠️  MIDTRANS_IS_PRODUCTION tidak ditemukan, default: false\n";
}

echo "\n=== CARA MENDAPATKAN CREDENTIALS ===\n\n";
echo "1. Buka: https://dashboard.midtrans.com/\n";
echo "2. Login atau Register\n";
echo "3. Pilih environment 'Sandbox' (untuk testing)\n";
echo "4. Buka menu: Settings → Access Keys\n";
echo "5. Copy Server Key dan Client Key\n";
echo "6. Paste ke file .env\n\n";

echo "=== CONTOH KONFIGURASI .ENV ===\n\n";
echo "MIDTRANS_SERVER_KEY=SB-Mid-server-xxxxxxxxxxxxx\n";
echo "MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxxxxxxxxxxx\n";
echo "MIDTRANS_IS_PRODUCTION=false\n\n";
