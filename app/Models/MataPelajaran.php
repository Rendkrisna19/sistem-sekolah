<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MataPelajaran extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function guru()
    {
        return $this->belongsToMany(Guru::class, 'guru_mata_pelajaran');
    }

     public function ujians() {
        return $this->hasMany(Ujian::class);
    }
}