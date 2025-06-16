<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

 class Ujian extends Model {
        use HasFactory;
        protected $guarded = ['id'];
        public function mataPelajaran() { return $this->belongsTo(MataPelajaran::class); }
        public function kelas() { return $this->belongsTo(Kelas::class); }
        public function nilais() { return $this->hasMany(Nilai::class); }
    }