<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

 class Nilai extends Model {
        use HasFactory;
        protected $guarded = ['id'];
        public function ujian() { return $this->belongsTo(Ujian::class); }
        public function siswa() { return $this->belongsTo(Siswa::class); }
    }