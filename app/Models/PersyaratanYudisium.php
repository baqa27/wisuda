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
        'status_verifikasi',
        'catatan_admin',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }
}
