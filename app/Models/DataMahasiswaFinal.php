<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataMahasiswaFinal extends Model
{
    use HasFactory;

    // Pastikan sesuai dengan nama tabel di database
    protected $table = 'data_mahasiswa_final';

    protected $fillable = [
        'mahasiswa_id',
        'nim',
        'pas_foto',
        'nama',
        'prodi',
        'ipk',
        'nama_ortu_1',
        'nama_ortu_2',
        'nama_tamu_1',
        'nama_tamu_2',
        'status',
    ];

    protected $casts = [
        'ipk' => 'decimal:2',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }
}
