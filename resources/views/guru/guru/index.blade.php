@extends('layouts.app')

@section('content')
    <div x-data="{
        showModal: false,
        // Data yang akan di-bind ke modal.
        guruData: {
            mapel_ids: []
        },
        formUrl: '',
        // Fungsi untuk membuka dan mengisi modal edit
        initEditForm(user) {
            this.formUrl = `{{ url('guru') }}/${user.id}`;
            // Jika user sudah punya profil guru, gunakan datanya. Jika tidak, siapkan data kosong.
            if (user.guru) {
                this.guruData = {
                    ...user.guru,
                    mapel_ids: user.guru.mata_pelajaran.map(mp => mp.id)
                };
            } else {
                this.guruData = {
                    nip: '',
                    no_telp: '',
                    mapel_ids: []
                };
            }
            this.showModal = true;
        }
    }">

        <h3 class="text-3xl font-medium text-gray-700">Data Profil Guru</h3>
        <p class="text-gray-600 mt-1">Halaman ini digunakan untuk melengkapi profil dari user yang memiliki peran sebagai guru.</p>


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

        <!-- Tabel Data Guru (berdasarkan User) -->
        <div class="flex flex-col mt-6">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle border-b border-gray-200 shadow sm:rounded-lg">
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Nama & Email</th>
                                <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">NIP & Telepon</th>
                                <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Mapel Diajar</th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @forelse ($userList as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        @if($user->guru)
                                            <div class="text-sm text-gray-900">NIP: {{ $user->guru->nip }}</div>
                                            <div class="text-sm text-gray-500">Tel: {{ $user->guru->no_telp }}</div>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Profil belum lengkap</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 border-b border-gray-200">
                                        <div class="flex flex-wrap gap-1">
                                            @forelse($user->guru->mataPelajaran ?? [] as $mapel)
                                                <span class="px-2 py-1 text-xs font-semibold text-indigo-800 bg-indigo-100 rounded-full">{{ $mapel->nama_mapel }}</span>
                                            @empty
                                                <span class="text-xs text-gray-500">-</span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium leading-5 text-right whitespace-no-wrap border-b border-gray-200">
                                        <button @click="initEditForm({{ $user->load('guru.mataPelajaran') }})" class="text-indigo-600 hover:text-indigo-900">
                                            {{ $user->guru ? 'Edit Profil' : 'Lengkapi Profil' }}
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-4 text-center text-gray-500 border-b border-gray-200">Tidak ada user dengan peran guru.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Edit Profil -->
        <div x-show="showModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="showModal" @click="showModal = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="inline-block w-full max-w-2xl p-8 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-lg">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Edit Profil Guru</h3>
                    
                    <form :action="formUrl" method="POST" class="mt-4">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <h4 class="font-semibold text-gray-700">Data Kepegawaian</h4>
                                <div>
                                    <label class="text-gray-700">NIP (Nomor Induk Pegawai)</label>
                                    <input type="text" name="nip" x-model="guruData.nip" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm ...">
                                    @error('nip') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="text-gray-700">No. Telepon</label>
                                    <input type="text" name="no_telp" x-model="guruData.no_telp" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm ...">
                                    @error('no_telp') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            
                            <div class="space-y-4">
                                <h4 class="font-semibold text-gray-700">Mata Pelajaran yang Diajar</h4>
                                <div class="p-4 border rounded-md h-48 overflow-y-auto space-y-2">
                                    @foreach($mapelList as $mapel)
                                    <label class="flex items-center">
                                        <input type="checkbox" name="mapel_ids[]" value="{{ $mapel->id }}" x-model="guruData.mapel_ids" class="rounded">
                                        <span class="ml-2 text-gray-700">{{ $mapel->nama_mapel }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end">
                            <button @click="showModal = false" type="button" class="px-4 py-2 text-sm font-medium tracking-wide text-gray-700 capitalize transition-colors duration-200 transform bg-gray-200 rounded-md hover:bg-gray-300 focus:outline-none">Batal</button>
                            <button type="submit" class="px-4 py-2 ml-2 text-sm font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-indigo-600 rounded-md hover:bg-indigo-500 focus:outline-none">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection