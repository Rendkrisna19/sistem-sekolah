@extends('layouts.app')

@section('content')
<div>
    <h3 class="text-3xl font-medium text-gray-700">Input Nilai Siswa</h3>
    
    <!-- Filter Form -->
    <div class="mt-4 p-6 bg-white rounded-md shadow-md">
        <p class="text-gray-600 mb-4">Silakan pilih kelas, lalu pilih ujian untuk menampilkan daftar siswa.</p>
        <form action="{{ route('nilai.index') }}" method="GET" id="filter-form">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="kelas_id" class="text-gray-700 font-semibold">Pilih Kelas</label>
                    {{-- Saat kelas diganti, form filter otomatis dikirim --}}
                    <select name="kelas_id" id="kelas_id" onchange="document.getElementById('filter-form').submit()" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach ($kelasList as $kelas)
                            <option value="{{ $kelas->id }}" {{ $selectedKelasId == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="ujian_id" class="text-gray-700 font-semibold">Pilih Ujian</label>
                    <select name="ujian_id" id="ujian_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" {{ $ujianList->isEmpty() ? 'disabled' : '' }}>
                         <option value="">-- Pilih Ujian --</option>
                        @foreach ($ujianList as $ujian)
                             <option value="{{ $ujian->id }}" {{ $selectedUjianId == $ujian->id ? 'selected' : '' }}>{{ $ujian->nama_ujian }} ({{ $ujian->mataPelajaran->nama_mapel }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-transparent">.</label>
                    <button type="submit" class="w-full px-4 py-2 mt-1 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-indigo-600 rounded-md hover:bg-indigo-500 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-80">
                        Tampilkan Siswa
                    </button>
                </div>
            </div>
        </form>
    </div>

    @if (session('success'))
        <div class="mt-4 px-4 py-2 font-medium text-white bg-green-500 rounded-md">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="mt-4 p-4 font-medium text-red-700 bg-red-100 border border-red-400 rounded-md">
            <p class="font-bold">Gagal menyimpan, terjadi kesalahan:</p>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Tabel Input Nilai -->
    @if($students->isNotEmpty())
    <form action="{{ route('nilai.store') }}" method="POST">
        @csrf
        <input type="hidden" name="ujian_id" value="{{ $selectedUjianId }}">
        <div class="flex flex-col mt-6">
            <div class="overflow-x-auto -my-2 sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Nama Lengkap</th>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">NIS</th>
                                    <th class="w-1/4 px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Nilai (0-100)</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($students as $index => $student)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $student->nama_lengkap }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $student->nis }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="hidden" name="nilais[{{ $index }}][siswa_id]" value="{{ $student->id }}">
                                            <input type="number" step="0.01" name="nilais[{{ $index }}][nilai]" value="{{ old('nilais.'.$index.'.nilai', $student->nilai) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Kosongkan jika tidak ada">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex justify-end mt-4">
            <button type="submit" class="px-6 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-green-600 rounded-md hover:bg-green-500 focus:outline-none focus:ring focus:ring-green-300 focus:ring-opacity-80">
                Simpan Semua Nilai
            </button>
        </div>
    </form>
    @elseif(request()->has('ujian_id') && request()->get('ujian_id') != '')
        <div class="mt-6 p-6 bg-white rounded-md shadow-md text-center text-gray-500">
            Tidak ada siswa yang ditemukan di kelas ini atau data filter tidak lengkap.
        </div>
    @endif
</div>
@endsection
