<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersyaratanWisuda extends Model
{
    use HasFactory;

    protected $table = 'persyaratan_wisuda'; // ✅ tambahkan ini

    protected $fillable = [
        'mahasiswa_id',
        'jenis',
        'file_path',
        'status',
        'catatan_admin'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }
}
