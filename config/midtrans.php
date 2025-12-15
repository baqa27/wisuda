<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Midtrans Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Midtrans Payment Gateway integration.
    | Get your credentials from: https://dashboard.midtrans.com/
    |
    */

    'server_key' => env('MIDTRANS_SERVER_KEY'),
    'client_key' => env('MIDTRANS_CLIENT_KEY'),

    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'is_sanitized' => env('MIDTRANS_IS_SANITIZED', true),
    'is_3ds' => env('MIDTRANS_IS_3DS', true),

    /*
    |--------------------------------------------------------------------------
    | Notification URL
    |--------------------------------------------------------------------------
    |
    | URL untuk menerima notifikasi dari Midtrans
    | Set di Midtrans Dashboard > Settings > Configuration
    |
    */

    'notification_url' => env('APP_URL') . '/midtrans/notification',

    /*
    |--------------------------------------------------------------------------
    | Finish URL
    |--------------------------------------------------------------------------
    |
    | URL redirect setelah pembayaran selesai
    |
    */

    'finish_url' => env('APP_URL') . '/yudisium/payment/success',
];
