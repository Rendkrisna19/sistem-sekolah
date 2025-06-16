@extends('layouts.app')

@section('content')
    <div x-data="{
        showModal: false,
        isEdit: false,
        ujianData: {},
        formUrl: '{{ route('ujian.store') }}',
        initForm(ujian = null) {
            if (ujian) {
                this.isEdit = true;
                this.formUrl = `{{ url('ujian') }}/${ujian.id}`;
                this.ujianData = { ...ujian };
            } else {
                this.isEdit = false;
                this.formUrl = '{{ route('ujian.store') }}';
                this.ujianData = { kelas_id: '{{ $kelasList->first()->id ?? '' }}', mata_pelajaran_id: '{{ $mapelList->first()->id ?? '' }}' };
            }
            this.showModal = true;
        }
    }">

        <h3 class="text-3xl font-medium text-gray-700">Data Ujian</h3>
        <div class="mt-4">
            <button @click="initForm()" class="px-4 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-indigo-600 rounded-md hover:bg-indigo-500 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-80">
                Tambah Ujian
            </button>
        </div>

        @if (session('success'))
            <div class="mt-4 px-4 py-2 font-medium text-white bg-green-500 rounded-md">{{ session('success') }}</div>
        @endif

        <div class="flex flex-col mt-6">
            <div class="overflow-x-auto -my-2 sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Nama Ujian</th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Mapel</th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Kelas</th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Tanggal</th>
                                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($ujianList as $ujian)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $ujian->nama_ujian }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $ujian->mataPelajaran->nama_mapel }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $ujian->kelas->nama_kelas }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($ujian->tanggal_ujian)->isoFormat('D MMMM Y') }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                            <!-- ### PERUBAHAN DI SINI: Tombol "Lihat Nilai" ditambahkan ### -->
                                            <a href="{{ route('ujian.showNilai', $ujian->id) }}" class="text-green-600 hover:text-green-900">Lihat Nilai</a>
                                            <button @click="initForm({{ $ujian }})" class="ml-2 text-indigo-600 hover:text-indigo-900">Edit</button>
                                            <form action="{{ route('ujian.destroy', $ujian->id) }}" method="POST" onsubmit="return confirm('Yakin?')" class="inline-block ml-2">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada data ujian.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal (Tidak ada perubahan) -->
        <div x-show="showModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="showModal" @click="showModal = false" x-transition class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                <div x-show="showModal" x-transition class="inline-block w-full max-w-lg p-8 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-lg">
                    <h3 class="text-lg font-medium leading-6 text-gray-900" x-text="isEdit ? 'Edit Ujian' : 'Tambah Ujian Baru'"></h3>
                    <form :action="formUrl" method="POST" class="mt-4 space-y-4">
                        @csrf
                        <template x-if="isEdit">@method('PUT')</template>
                        <div>
                            <label class="text-gray-700">Nama Ujian</label>
                            <input type="text" name="nama_ujian" x-model="ujianData.nama_ujian" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label class="text-gray-700">Kelas</label>
                            <select name="kelas_id" x-model="ujianData.kelas_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @foreach($kelasList as $kelas)
                                <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="text-gray-700">Mata Pelajaran</label>
                            <select name="mata_pelajaran_id" x-model="ujianData.mata_pelajaran_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @foreach($mapelList as $mapel)
                                <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="text-gray-700">Tanggal Ujian</label>
                            <input type="date" name="tanggal_ujian" x-model="ujianData.tanggal_ujian" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label class="text-gray-700">Keterangan (Opsional)</label>
                            <textarea name="keterangan" x-model="ujianData.keterangan" rows="3" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                        </div>
                        <div class="mt-8 flex justify-end">
                            <button @click="showModal = false" type="button" class="px-4 py-2 bg-gray-200 rounded-md text-gray-700 hover:bg-gray-300">Batal</button>
                            <button type="submit" class="px-4 py-2 ml-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
