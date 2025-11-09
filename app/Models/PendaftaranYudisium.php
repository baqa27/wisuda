<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranYudisium extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran_yudisium';

    protected $fillable = [
        'mahasiswa_id',
        'kode_invoice',
        'total_bayar',
        'status',
        'tanggal_bayar',
        'bukti_bayar'
    ];

    protected $casts = [
        'tanggal_bayar' => 'datetime',
        'total_bayar' => 'decimal:2'
    ];

    // Jika tabel tidak memiliki created_at & updated_at
    // public $timestamps = false;

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    // Tambahan opsional: label status untuk tampilan
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'menunggu_pembayaran' => 'Menunggu Pembayaran',
            'menunggu_verifikasi' => 'Menunggu Verifikasi Admin',
            'lunas' => 'Lunas',
            'batal' => 'Dibatalkan',
            default => 'Tidak Diketahui',
        };
    }
}
