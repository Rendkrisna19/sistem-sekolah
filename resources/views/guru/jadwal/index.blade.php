@extends('layouts.app')

@section('content')
    <div x-data="{
        showModal: false,
        isEdit: false,
        jadwalData: {},
        formUrl: '{{ route('jadwal.store') }}',
        initForm(jadwal = null) {
            if (jadwal) {
                this.isEdit = true;
                this.formUrl = `{{ url('jadwal') }}/${jadwal.id}`;
                this.jadwalData = { ...jadwal };
            } else {
                this.isEdit = false;
                this.formUrl = '{{ route('jadwal.store') }}';
                this.jadwalData = { hari: 'Senin' }; // Default value for new entry
            }
            this.showModal = true;
        }
    }">
        <h3 class="text-3xl font-medium text-gray-700">Jadwal Pelajaran</h3>

        <div class="mt-4">
            <button @click="initForm()" class="px-4 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-indigo-600 rounded-md hover:bg-indigo-500 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-80">
                Tambah Jadwal
            </button>
        </div>
        
        @if (session('success'))
            <div class="mt-4 px-4 py-2 font-medium text-white bg-green-500 rounded-md">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
             <div class="mt-4 p-4 font-medium text-red-700 bg-red-100 border border-red-400 rounded-md">
                <p class="font-bold">Terjadi Kesalahan:</p>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($hari as $h)
                <div class="bg-white rounded-lg shadow-md p-4 flex flex-col">
                    <h4 class="font-bold text-lg text-gray-800 border-b pb-2 mb-4">{{ $h }}</h4>
                    <div class="space-y-3 flex-grow">
                        @forelse ($jadwalByDay[$h] ?? [] as $jadwal)
                            <div class="p-3 bg-indigo-50 rounded-lg border border-indigo-200 relative group">
                                <p class="font-semibold text-indigo-800">{{ $jadwal->mataPelajaran->nama_mapel }}</p>
                                <p class="text-sm text-gray-600">Kelas: {{ $jadwal->kelas->nama_kelas }}</p>
                                <p class="text-sm text-gray-600">Guru: {{ $jadwal->guru->user->name }}</p>
                                <p class="text-sm text-gray-500 mt-1 font-mono">{{ date('H:i', strtotime($jadwal->jam_mulai)) }} - {{ date('H:i', strtotime($jadwal->jam_selesai)) }}</p>
                                <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button @click="initForm({{ $jadwal }})" class="p-1 text-blue-600 hover:text-blue-800">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L16.732 3.732z"></path></svg>
                                    </button>
                                     <form action="{{ route('jadwal.destroy', $jadwal->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Anda yakin ingin menghapus jadwal ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1 text-red-600 hover:text-red-800">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-center text-gray-400 mt-4">Tidak ada jadwal.</p>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Modal -->
        <div x-show="showModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="showModal" @click="showModal = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="inline-block w-full max-w-lg p-8 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-lg">
                    <h3 class="text-lg font-medium leading-6 text-gray-900" x-text="isEdit ? 'Edit Jadwal' : 'Tambah Jadwal Baru'"></h3>
                    
                    <form :action="formUrl" method="POST" class="mt-4 space-y-4">
                        @csrf
                        <template x-if="isEdit">@method('PUT')</template>
                        
                        <div>
                            <label class="text-gray-700">Hari</label>
                            <select name="hari" x-model="jadwalData.hari" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @foreach($hari as $h)
                                    <option value="{{ $h }}">{{ $h }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="text-gray-700">Kelas</label>
                            <select name="kelas_id" x-model="jadwalData.kelas_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm ...">
                                @foreach($kelasList as $kelas)
                                    <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="text-gray-700">Mata Pelajaran</label>
                            <select name="mata_pelajaran_id" x-model="jadwalData.mata_pelajaran_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm ...">
                                @foreach($mapelList as $mapel)
                                    <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="text-gray-700">Guru Pengajar</label>
                            <select name="guru_id" x-model="jadwalData.guru_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm ...">
                                @foreach($guruList as $guru)
                                    <option value="{{ $guru->id }}">{{ $guru->user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-gray-700">Jam Mulai</label>
                                <input type="time" name="jam_mulai" x-model="jadwalData.jam_mulai" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm ...">
                            </div>
                            <div>
                                <label class="text-gray-700">Jam Selesai</label>
                                <input type="time" name="jam_selesai" x-model="jadwalData.jam_selesai" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm ...">
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end">
                            <button @click="showModal = false" type="button" class="px-4 py-2 text-sm font-medium tracking-wide text-gray-700 capitalize transition-colors duration-200 transform bg-gray-200 rounded-md hover:bg-gray-300 focus:outline-none">Batal</button>
                            <button type="submit" class="px-4 py-2 ml-2 text-sm font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-indigo-600 rounded-md hover:bg-indigo-500 focus:outline-none">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
