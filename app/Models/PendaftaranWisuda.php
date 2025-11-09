<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranWisuda extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran_wisuda'; // tambahkan baris ini

    protected $fillable = [
        'mahasiswa_id',
        'kode_invoice',
        'total_bayar',
        'status',
        'tanggal_bayar',
        'bukti_bayar',
    ];

    protected $casts = [
        'tanggal_bayar' => 'datetime',
        'total_bayar' => 'decimal:2',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }
}
