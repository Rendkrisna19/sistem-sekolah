@extends('layouts.app')

@section('content')
<div>
    <!-- Header Halaman -->
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-3xl font-medium text-gray-700">Hasil Ujian: {{ $ujian->nama_ujian }}</h3>
            <div class="mt-1 text-sm text-gray-600">
                <span class="font-semibold">Kelas:</span> {{ $ujian->kelas->nama_kelas }} | 
                <span class="font-semibold">Mapel:</span> {{ $ujian->mataPelajaran->nama_mapel }} |
                <span class="font-semibold">Tanggal:</span> {{ \Carbon\Carbon::parse($ujian->tanggal_ujian)->isoFormat('D MMMM Y') }}
            </div>
        </div>
        <a href="{{ route('ujian.index') }}" class="px-4 py-2 font-medium tracking-wide text-gray-700 capitalize transition-colors duration-200 transform bg-gray-200 rounded-md hover:bg-gray-300 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-80">
            &larr; Kembali ke Daftar Ujian
        </a>
    </div>

    <!-- Tabel Hasil Nilai -->
    <div class="flex flex-col mt-6">
        <div class="overflow-x-auto -my-2 sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">No</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Nama Siswa</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">NIS</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Nilai</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($siswas as $index => $siswa)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $siswa->nama_lengkap }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $siswa->nis }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap font-semibold {{ ($siswa->nilai ?? 0) < 70 ? 'text-red-600' : 'text-green-600' }}">
                                        {{ $siswa->nilai ?? 'Belum dinilai' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                        Tidak ada siswa di kelas ini.
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
