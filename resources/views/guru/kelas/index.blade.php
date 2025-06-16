@extends('layouts.app')

@section('content')
    <div x-data="{
        showModal: false,
        isEdit: false,
        kelasData: {},
        formUrl: '{{ route('kelas.store') }}',
        initForm(kelas = null) {
            if (kelas) {
                this.isEdit = true;
                this.formUrl = '{{ url('kelas') }}/' + kelas.id;
                this.kelasData = { ...kelas };
            } else {
                this.isEdit = false;
                this.formUrl = '{{ route('kelas.store') }}';
                this.kelasData = {};
            }
            this.showModal = true;
        }
    }">

        <h3 class="text-3xl font-medium text-gray-700">Data Kelas</h3>

        <div class="mt-4">
            <button @click="initForm()" class="px-4 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-indigo-600 rounded-md hover:bg-indigo-500 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-80">
                Tambah Kelas
            </button>
        </div>

        @if (session('success'))
            <div class="mt-4 px-4 py-2 font-medium text-white bg-green-500 rounded-md">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mt-4 px-4 py-2 font-medium text-white bg-red-500 rounded-md">
                {{ session('error') }}
            </div>
        @endif


        <div class="flex flex-col mt-6">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle border-b border-gray-200 shadow sm:rounded-lg">
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Nama Kelas</th>
                                <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Tingkat</th>
                                <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">Jumlah Siswa</th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @forelse ($kelasList as $kelas)
                                <tr>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">{{ $kelas->nama_kelas }}</td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">{{ $kelas->tingkat }}</td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">{{ $kelas->siswas()->count() }}</td>
                                    <td class="px-6 py-4 text-sm font-medium leading-5 text-right whitespace-no-wrap border-b border-gray-200">
                                        <button @click="initForm({{ $kelas }})" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                        <form action="{{ route('kelas.destroy', $kelas->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="ml-2 text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500 border-b border-gray-200">Tidak ada data kelas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div x-show="showModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="showModal" @click="showModal = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="inline-block w-full max-w-md p-8 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-lg">
                    <h3 class="text-lg font-medium leading-6 text-gray-900" x-text="isEdit ? 'Edit Kelas' : 'Tambah Kelas Baru'"></h3>
                    
                    <form :action="formUrl" method="POST" class="mt-4">
                        @csrf
                        <template x-if="isEdit">
                            @method('PUT')
                        </template>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="text-gray-700" for="nama_kelas">Nama Kelas</label>
                                <input id="nama_kelas" type="text" name="nama_kelas" x-model="kelasData.nama_kelas" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 focus:outline-none focus:ring" required>
                            </div>
                            <div>
                                <label class="text-gray-700" for="tingkat">Tingkat</label>
                                <input id="tingkat" type="text" name="tingkat" x-model="kelasData.tingkat" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 focus:outline-none focus:ring" placeholder="Contoh: 10, 11, atau 12" required>
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end">
                            <button @click="showModal = false" type="button" class="px-4 py-2 mr-3 text-sm font-medium tracking-wide text-gray-700 capitalize transition-colors duration-200 transform bg-gray-200 rounded-md hover:bg-gray-300 focus:outline-none">
                                Batal
                            </button>
                            <button type="submit" class="px-4 py-2 text-sm font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-indigo-600 rounded-md hover:bg-indigo-500 focus:outline-none">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection