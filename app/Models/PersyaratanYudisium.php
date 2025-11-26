<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersyaratanYudisium extends Model
{
    use HasFactory;

    protected $table = 'persyaratan_yudisium'; // 🟢 tambahkan ini

    protected $fillable = [
        'mahasiswa_id',
        'judul_ta',
        'dosen_pembimbing',
        'file_ktp',
        'file_ijazah',
        'no_whatsapp',
        'sertifikasi_tahfidz',
        'sertifikasi_toefl',
        'surat_bebas_perpustakaan',
        'status',
        'catatan_admin',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }
}
