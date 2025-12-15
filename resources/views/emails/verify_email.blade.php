<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            background: linear-gradient(95.08deg, #0A0061 -3.06%, #0061DF 95.31%);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }

        .email-header h1 {
            margin: 0;
            font-size: 28px;
        }

        .email-header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
        }

        .email-body {
            padding: 40px 30px;
        }

        .email-body h2 {
            color: #0061DF;
            margin-top: 0;
        }

        .email-body p {
            color: #666;
            line-height: 1.6;
        }

        .verify-button {
            display: inline-block;
            padding: 15px 40px;
            background: linear-gradient(95.08deg, #0A0061 -3.06%, #0061DF 95.31%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin: 20px 0;
            font-weight: bold;
            font-size: 16px;
        }

        .verify-button:hover {
            opacity: 0.9;
        }

        .info-box {
            background-color: #f8f9fa;
            border-left: 4px solid #0061DF;
            padding: 15px;
            margin: 20px 0;
        }

        .email-footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 12px;
        }

        .divider {
            height: 1px;
            background-color: #e0e0e0;
            margin: 30px 0;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            <h1>🎓 Verifikasi Email Anda</h1>
            <p>Sistem Wisuda</p>
        </div>

        <div class="email-body">
            <h2>Halo, {{ $user->name }}!</h2>

            <p>Terima kasih telah mendaftar di Sistem Wisuda. Untuk melengkapi proses registrasi, silakan verifikasi
                alamat email Anda dengan mengklik tombol di bawah ini:</p>

            <center>
                <a href="{{ $verificationUrl }}" class="verify-button">
                    ✓ Verifikasi Email Saya
                </a>
            </center>

            <div class="info-box">
                <p style="margin: 0;"><strong>Atau salin link berikut ke browser Anda:</strong></p>
                <p style="margin: 10px 0 0 0; word-break: break-all;">
                    <a href="{{ $verificationUrl }}" style="color: #0061DF;">{{ $verificationUrl }}</a>
                </p>
            </div>

            <div class="divider"></div>

            <p><strong>Informasi Akun Anda:</strong></p>
            <ul style="color: #666;">
                <li>Nama: {{ $user->name }}</li>
                <li>Email: {{ $user->email }}</li>
                @if($user->nim)
                    <li>NIM: {{ $user->nim }}</li>
                @endif
            </ul>

            <p style="color: #999; font-size: 14px; margin-top: 30px;">
                <strong>Catatan:</strong> Jika Anda tidak mendaftar di Sistem Wisuda, abaikan email ini.
            </p>
        </div>

        <div class="email-footer">
            <p>Email ini dikirim secara otomatis oleh Sistem Wisuda.</p>
            <p>Jangan balas email ini.</p>
            <p>&copy; {{ date('Y') }} Sistem Wisuda. All rights reserved.</p>
        </div>
    </div>
</body>

</html>