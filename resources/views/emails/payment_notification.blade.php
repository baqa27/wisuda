<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Pembayaran Yudisium</title>
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
            padding: 30px;
            text-align: center;
            color: white;
        }

        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }

        .email-body {
            padding: 30px;
        }

        .info-box {
            background-color: #f8f9fa;
            border-left: 4px solid #0061DF;
            padding: 15px;
            margin: 20px 0;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: bold;
            color: #333;
        }

        .info-value {
            color: #666;
        }

        .button {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(95.08deg, #0A0061 -3.06%, #0061DF 95.31%);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
        }

        .email-footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 12px;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            background-color: #28a745;
            color: white;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            <h1>🎓 Notifikasi Pembayaran Yudisium</h1>
        </div>

        <div class="email-body">
            <p>Halo Admin,</p>

            <p>Ada pembayaran yudisium baru yang telah berhasil diproses melalui <strong>Midtrans</strong>.</p>

            <div class="info-box">
                <h3 style="margin-top: 0; color: #0061DF;">Detail Pembayaran</h3>

                <div class="info-row">
                    <span class="info-label">Kode Invoice:</span>
                    <span class="info-value">{{ $pendaftaran->kode_invoice }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label">Nama Mahasiswa:</span>
                    <span class="info-value">{{ $mahasiswa->name }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label">NIM:</span>
                    <span class="info-value">{{ $mahasiswa->nim }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value">{{ $mahasiswa->email }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label">Total Bayar:</span>
                    <span class="info-value">Rp {{ number_format($pendaftaran->total_bayar, 0, ',', '.') }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label">Metode Pembayaran:</span>
                    <span class="info-value">{{ strtoupper($pendaftaran->payment_method ?? 'Midtrans') }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label">Tanggal Bayar:</span>
                    <span
                        class="info-value">{{ $pendaftaran->paid_at ? $pendaftaran->paid_at->format('d F Y, H:i') : now()->format('d F Y, H:i') }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label">Status:</span>
                    <span class="info-value">
                        <span class="status-badge">LUNAS</span>
                    </span>
                </div>
            </div>

            <p><strong>Tindakan yang diperlukan:</strong></p>
            <ul>
                <li>Verifikasi pembayaran di sistem admin</li>
                <li>Pastikan data mahasiswa sudah sesuai</li>
                <li>Mahasiswa dapat melanjutkan ke tahap persyaratan setelah pembayaran disetujui</li>
            </ul>

            <center>
                <a href="{{ url('/admin/verifikasi/pembayaran-yudisium') }}" class="button">
                    Lihat di Dashboard Admin
                </a>
            </center>
        </div>

        <div class="email-footer">
            <p>Email ini dikirim secara otomatis oleh Sistem Wisuda.</p>
            <p>Jangan balas email ini.</p>
            <p>&copy; {{ date('Y') }} Sistem Wisuda. All rights reserved.</p>
        </div>
    </div>
</body>

</html>