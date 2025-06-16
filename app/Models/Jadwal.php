<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jadwal extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function kelas() { return $this->belongsTo(Kelas::class); }
    public function guru() { return $this->belongsTo(Guru::class); }
    public function mataPelajaran() { return $this->belongsTo(MataPelajaran::class); }
}