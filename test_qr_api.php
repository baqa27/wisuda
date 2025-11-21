#!/usr/bin/env php
<?php

/**
 * Script untuk test QR Code generation dan API endpoints
 * Jalankan dari terminal: php test_qr_api.php
 */

$appUrl = 'http://localhost:8000';
$apiToken = 'test_token_12345678901234567890ab';
$kodeUnik = '150001_1731705600';

echo "========================================\n";
echo "🧪 QR CODE API TEST SUITE\n";
echo "========================================\n\n";

// Test 1: Check Status QR
echo "Test 1: Check QR Status\n";
echo "URL: GET {$appUrl}/api/qr/status/{$apiToken}\n\n";

// Test 2: Submit Checkin
echo "Test 2: Submit QR Checkin\n";
echo "URL: POST {$appUrl}/api/qr/checkin\n";
echo "Body:\n";
$checkInData = [
    'token' => $apiToken,
    'kode_unik' => $kodeUnik
];
echo json_encode($checkInData, JSON_PRETTY_PRINT) . "\n\n";

// Test 3: List Presensi
echo "Test 3: List All Presensi\n";
echo "URL: GET {$appUrl}/api/qr/list-presensi\n\n";

// Test 4: Download QR File
echo "Test 4: Download QR File\n";
echo "URL: GET {$appUrl}/api/qr/file/1\n\n";

echo "========================================\n";
echo "📝 Testing Notes:\n";
echo "========================================\n";
echo "1. Pastikan aplikasi sudah running (php artisan serve)\n";
echo "2. QR code perlu di-generate terlebih dahulu dari admin dashboard\n";
echo "3. Ganti token dan kode_unik dengan nilai dari QR yang sudah di-generate\n";
echo "4. Gunakan curl atau aplikasi seperti Postman untuk test:\n\n";

$commands = [
    "Test Status: curl http://localhost:8000/api/qr/status/YOUR_TOKEN",
    "Test Checkin: curl -X POST http://localhost:8000/api/qr/checkin -H 'Content-Type: application/json' -d '{\"token\":\"YOUR_TOKEN\",\"kode_unik\":\"YOUR_KODE_UNIK\"}'",
    "Test List: curl http://localhost:8000/api/qr/list-presensi",
    "Test Download: curl -o qr_file.svg http://localhost:8000/api/qr/file/1"
];

foreach ($commands as $cmd) {
    echo "$ " . $cmd . "\n";
}

echo "\n========================================\n";
echo "✅ Documentation: API_QR_DOCUMENTATION.md\n";
echo "========================================\n";
?>
