@extends('layouts.app')

@section('content')
<div>
    <h3 class="text-3xl font-medium text-gray-700">Dashboard Kepala Sekolah</h3>
    <p class="mt-1 text-gray-600">Ringkasan data sekolah secara keseluruhan.</p>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 gap-6 mt-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="p-5 bg-white rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="p-3 bg-blue-500 rounded-full"><svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" /></svg></div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Guru</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalGuru }}</p>
                </div>
            </div>
        </div>
        <div class="p-5 bg-white rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="p-3 bg-indigo-500 rounded-full"><svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg></div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Siswa</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalSiswa }}</p>
                </div>
            </div>
        </div>
        <div class="p-5 bg-white rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="p-3 bg-green-500 rounded-full"><svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h12A2.25 2.25 0 0 0 20.25 14.25V3.75M3.75 3h16.5M3.75 3v.75A2.25 2.25 0 0 1 1.5 6v.75m0 0v1.5m0 0v.75a2.25 2.25 0 0 0 2.25 2.25h1.5M12 16.5v.75m0 0v1.5m0 0v.75m0 0h1.5m-1.5 0h-1.5m-6-12v.75m0 0v1.5m0 0v.75a2.25 2.25 0 0 0 2.25 2.25h1.5M12 3v.75m0 0v1.5m0 0v.75a2.25 2.25 0 0 1-2.25 2.25h-1.5M12 3h1.5m-1.5 0h-1.5" /></svg></div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Kelas</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalKelas }}</p>
                </div>
            </div>
        </div>
        <div class="p-5 bg-white rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="p-3 bg-orange-500 rounded-full"><svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg></div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Kehadiran Hari Ini</p>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($persentaseKehadiran, 1) }}%</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
