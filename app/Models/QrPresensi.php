<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrPresensi extends Model
{
    use HasFactory;

    protected $table = 'qr_presensi';

    protected $fillable = [
        'mahasiswa_id',
        'token',
        'kode_unik',
        'file_qr',
        'status',
        'waktu_checkin',
        'expired_at'
    ];

    protected $casts = [
        'waktu_checkin' => 'datetime',
        'expired_at' => 'datetime'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    // HAPUS method static yang bermasalah
    // Method generate sudah dipindah ke controller
}
