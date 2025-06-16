@extends('layouts.app')

@section('content')
<div>
    <h3 class="text-3xl font-medium text-gray-700">Raport Siswa</h3>

    <!-- Form Filter -->
    <div class="mt-4 p-6 bg-white rounded-md shadow-md">
        <form action="{{ route('raport.index') }}" method="GET" id="filter-raport-form">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="kelas_id" class="text-gray-700 font-semibold">1. Pilih Kelas</label>
                    <select name="kelas_id" id="kelas_id" onchange="this.form.submit()" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">-- Pilih Kelas untuk Menampilkan Siswa --</option>
                        @foreach ($kelasList as $kelas)
                            <option value="{{ $kelas->id }}" {{ $selectedKelasId == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                @if($siswaList->isNotEmpty())
                <div>
                    <label for="siswa_id" class="text-gray-700 font-semibold">2. Pilih Siswa</label>
                    <select name="siswa_id" id="siswa_id" onchange="if (this.value) window.location.href='{{ url('raport') }}/' + this.value" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">-- Pilih Siswa untuk Melihat Raport --</option>
                        @foreach ($siswaList as $siswa)
                            <option value="{{ $siswa->id }}">{{ $siswa->nama_lengkap }} (NIS: {{ $siswa->nis }})</option>
                        @endforeach
                    </select>
                </div>
                @endif
            </div>
        </form>
    </div>

    @if($selectedKelasId && $siswaList->isEmpty())
    <div class="mt-6 p-6 bg-white rounded-md shadow-md text-center">
        <p class="text-gray-500">Tidak ada siswa yang ditemukan di kelas ini.</p>
    </div>
    @endif
</div>
@endsection
