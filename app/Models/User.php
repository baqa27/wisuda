<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\PendaftaranWisuda;
use App\Models\PendaftaranYudisium;
use App\Models\PersyaratanYudisium;
use App\Models\PersyaratanWisuda;
use App\Models\QrPresensi;
use App\Models\DataMahasiswaFinal;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nim',
        'prodi',
        'ipk',
        'pas_foto',
        'no_hp'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationships
    public function pendaftaranYudisium()
    {
        return $this->hasOne(PendaftaranYudisium::class, 'mahasiswa_id');
    }

    public function persyaratanYudisium()
    {
        return $this->hasOne(PersyaratanYudisium::class, 'mahasiswa_id');
    }

    public function pendaftaranWisuda()
    {
        return $this->hasOne(PendaftaranWisuda::class, 'mahasiswa_id');
    }

    public function persyaratanWisuda()
    {
        return $this->hasMany(PersyaratanWisuda::class, 'mahasiswa_id');
    }

    public function qrPresensi()
    {
        return $this->hasOne(QrPresensi::class, 'mahasiswa_id');
    }

    public function dataFinal()
    {
        return $this->hasOne(DataMahasiswaFinal::class, 'mahasiswa_id');
    }

    // Scope untuk role
    public function scopeMahasiswa($query)
    {
        return $query->where('role', 'mahasiswa');
    }

    public function scopeAdmin($query)
    {
        return $query->where('role', 'admin');
    }

    // Helper methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isMahasiswa()
    {
        return $this->role === 'mahasiswa';
    }
}
