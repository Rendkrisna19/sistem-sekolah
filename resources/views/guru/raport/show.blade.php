@extends('layouts.app')

@section('content')
<div>
    <!-- Header Raport -->
    <div class="p-6 bg-white rounded-lg shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-2xl font-bold text-gray-800">RAPORT SISWA</h3>
                <p class="text-gray-600">Tahun Ajaran 2024/2025 - Semester Ganjil</p>
            </div>
            <a href="{{ route('raport.index', ['kelas_id' => $siswa->kelas_id]) }}" class="px-4 py-2 text-sm font-medium tracking-wide text-gray-700 capitalize transition-colors duration-200 transform bg-gray-200 rounded-md hover:bg-gray-300">
                &larr; Kembali
            </a>
        </div>
        <div class="mt-6 border-t pt-4 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <p><span class="font-semibold w-24 inline-block">Nama Siswa</span>: {{ $siswa->nama_lengkap }}</p>
                <p><span class="font-semibold w-24 inline-block">NIS</span>: {{ $siswa->nis }}</p>
            </div>
            <div>
                <p><span class="font-semibold w-24 inline-block">Kelas</span>: {{ $siswa->kelas->nama_kelas }}</p>
            </div>
        </div>
    </div>

    <!-- Tabel Nilai Raport -->
    <div class="flex flex-col mt-6">
        <div class="overflow-x-auto -my-2 sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden border border-gray-200 shadow sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-sm font-semibold tracking-wider text-left text-gray-600 uppercase">No</th>
                                <th scope="col" class="px-6 py-3 text-sm font-semibold tracking-wider text-left text-gray-600 uppercase">Mata Pelajaran</th>
                                <th scope="col" class="px-6 py-3 text-sm font-semibold tracking-wider text-center text-gray-600 uppercase">Rata-Rata Nilai Ujian</th>
                                <th scope="col" class="px-6 py-3 text-sm font-semibold tracking-wider text-center text-gray-600 uppercase">Predikat</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php $i = 1; @endphp
                            @forelse ($nilaiByMapel as $mapel => $nilais)
                                @php
                                    // Hitung rata-rata nilai untuk mapel ini
                                    $average = $nilais->avg('nilai');
                                    // Tentukan predikat berdasarkan rata-rata
                                    $predikat = '-';
                                    if ($average >= 90) $predikat = 'A';
                                    elseif ($average >= 80) $predikat = 'B';
                                    elseif ($average >= 70) $predikat = 'C';
                                    else $predikat = 'D';
                                @endphp
                                <tr>
                                    <td class="px-6 py-4 text-center whitespace-nowrap">{{ $i++ }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $mapel }}</td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap font-bold text-lg {{ $average < 70 ? 'text-red-500' : 'text-gray-800' }}">
                                        {{ number_format($average, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap font-semibold">
                                        {{ $predikat }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                        Belum ada data nilai yang diinput untuk siswa ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
