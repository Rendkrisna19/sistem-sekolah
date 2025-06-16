<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kelas extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function siswas()
    {
        return $this->hasMany(Siswa::class);
    }

     public function ujians() {
        return $this->hasMany(Ujian::class);
    }
}