<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function orangTua()
    {
        return $this->hasOne(OrangTua::class);
    }

     public function nilais() {
        return $this->hasMany(Nilai::class);
    }

    public function absensi() {
    return $this->hasMany(AbsensiSiswa::class);
}
}