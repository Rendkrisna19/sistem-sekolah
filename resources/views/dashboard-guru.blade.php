@extends('layouts.app')

@section('content')
<div>
    <!-- Header Sambutan -->
    <h3 class="text-3xl font-medium text-gray-700">Dashboard</h3>
    <p class="mt-1 text-gray-600">Selamat datang kembali, {{ Auth::user()->name }}!</p>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 gap-6 mt-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="p-5 bg-white rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="p-3 bg-indigo-500 rounded-full">
                    <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Siswa</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalSiswa }}</p>
                </div>
            </div>
        </div>
        <div class="p-5 bg-white rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="p-3 bg-green-500 rounded-full">
                     <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h12A2.25 2.25 0 0 0 20.25 14.25V3.75M3.75 3h16.5M3.75 3v.75A2.25 2.25 0 0 1 1.5 6v.75m0 0v1.5m0 0v.75a2.25 2.25 0 0 0 2.25 2.25h1.5M12 16.5v.75m0 0v1.5m0 0v.75m0 0h1.5m-1.5 0h-1.5m-6-12v.75m0 0v1.5m0 0v.75a2.25 2.25 0 0 0 2.25 2.25h1.5M12 3v.75m0 0v1.5m0 0v.75a2.25 2.25 0 0 1-2.25 2.25h-1.5M12 3h1.5m-1.5 0h-1.5" /></svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Kelas Diajar</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalKelas }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Jadwal Hari Ini & Info Lainnya -->
    <div class="grid grid-cols-1 gap-6 mt-6 lg:grid-cols-2">
        <!-- Kolom Jadwal Hari Ini -->
        <div class="p-6 bg-white rounded-lg shadow-md">
            <h4 class="text-lg font-semibold text-gray-800">Jadwal Anda Hari Ini ({{ now()->isoFormat('dddd, D MMMM Y') }})</h4>
            <div class="mt-4 space-y-3">
                @forelse ($jadwalHariIni as $jadwal)
                    <div class="p-4 bg-indigo-50 rounded-lg border border-indigo-200">
                        <p class="font-bold text-indigo-800">{{ $jadwal->mataPelajaran->nama_mapel }}</p>
                        <div class="text-sm text-gray-600">
                            <span>Kelas {{ $jadwal->kelas->nama_kelas }}</span>
                            <span class="mx-2">|</span>
                            <span class="font-mono">{{ date('H:i', strtotime($jadwal->jam_mulai)) }} - {{ date('H:i', strtotime($jadwal->jam_selesai)) }}</span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 text-gray-500">
                        <p>Tidak ada jadwal mengajar hari ini. Selamat beristirahat!</p>
                    </div>
                @endforelse
            </div>
        </div>
        
        <!-- Kolom Quick Links -->
        <div class="p-6 bg-white rounded-lg shadow-md">
            <h4 class="text-lg font-semibold text-gray-800">Akses Cepat</h4>
            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <a href="{{ route('nilai.index') }}" class="p-4 text-center bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                    <p class="font-semibold text-green-800">Input Nilai</p>
                    <p class="text-sm text-green-600">Masuk ke halaman input nilai ujian siswa</p>
                </a>
                <a href="{{ route('jadwal.index') }}" class="p-4 text-center bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <p class="font-semibold text-blue-800">Lihat Jadwal</p>
                    <p class="text-sm text-blue-600">Lihat jadwal pelajaran mingguan</p>
                </a>
                <a href="{{ route('raport.index') }}" class="p-4 text-center bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                    <p class="font-semibold text-purple-800">Cek Raport</p>
                    <p class="text-sm text-purple-600">Lihat rekapitulasi nilai siswa</p>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection