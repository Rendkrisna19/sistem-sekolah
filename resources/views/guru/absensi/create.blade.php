@extends('layouts.app')

@section('content')
<div>
    <h3 class="text-3xl font-medium text-gray-700">Absensi Siswa</h3>
    
    <!-- Filter Form -->
    <div class="mt-4 p-6 bg-white rounded-md shadow-md">
        <form action="{{ route('absensi.siswa.create') }}" method="GET" id="filter-absensi-form">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="kelas_id" class="text-gray-700 font-semibold">Pilih Kelas</label>
                    <select name="kelas_id" id="kelas_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach ($kelasList as $kelas)
                            <option value="{{ $kelas->id }}" {{ $selectedKelasId == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="tanggal_absensi" class="text-gray-700 font-semibold">Pilih Tanggal</label>
                    <input type="date" name="tanggal_absensi" id="tanggal_absensi" value="{{ $selectedTanggal }}" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
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

    <!-- Tabel Absensi -->
    @if($students->isNotEmpty())
    <div class="mt-6">
        <!-- Tombol Export -->
        <div class="flex justify-end space-x-2 mb-4">
            <button id="export-pdf" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-500 focus:outline-none">
                Cetak PDF
            </button>
            <button id="export-excel" class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-500 focus:outline-none">
                Export Excel
            </button>
        </div>
        
        <form action="{{ route('absensi.siswa.store') }}" method="POST">
            @csrf
            <input type="hidden" name="kelas_id" value="{{ $selectedKelasId }}">
            <input type="hidden" name="tanggal_absensi" value="{{ $selectedTanggal }}">
            <div class="overflow-x-auto -my-2 sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200" id="absensi-table">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Nama Lengkap</th>
                                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Status Kehadiran</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($students as $index => $student)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap" data-name="{{ $student->nama_lengkap }}">{{ $student->nama_lengkap }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="hidden" name="absensi[{{ $index }}][siswa_id]" value="{{ $student->id }}">
                                            <div class="flex items-center space-x-4">
                                                <label class="inline-flex items-center">
                                                    <input type="radio" name="absensi[{{ $index }}][status]" value="Hadir" class="text-green-600 form-radio" {{ $student->status == 'Hadir' ? 'checked' : '' }}>
                                                    <span class="ml-2 text-green-700">Hadir</span>
                                                </label>
                                                <label class="inline-flex items-center">
                                                    <input type="radio" name="absensi[{{ $index }}][status]" value="Sakit" class="text-yellow-600 form-radio" {{ $student->status == 'Sakit' ? 'checked' : '' }}>
                                                    <span class="ml-2 text-yellow-700">Sakit</span>
                                                </label>
                                                <label class="inline-flex items-center">
                                                    <input type="radio" name="absensi[{{ $index }}][status]" value="Izin" class="text-blue-600 form-radio" {{ $student->status == 'Izin' ? 'checked' : '' }}>
                                                    <span class="ml-2 text-blue-700">Izin</span>
                                                </label>
                                                <label class="inline-flex items-center">
                                                    <input type="radio" name="absensi[{{ $index }}][status]" value="Alpa" class="text-red-600 form-radio" {{ $student->status == 'Alpa' ? 'checked' : '' }}>
                                                    <span class="ml-2 text-red-700">Alpa</span>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="flex justify-end mt-4">
                <button type="submit" class="px-6 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-green-600 rounded-md hover:bg-green-500 focus:outline-none focus:ring focus:ring-green-300 focus:ring-opacity-80">
                    Simpan Absensi
                </button>
            </div>
        </form>
    </div>
    @elseif(request()->filled('kelas_id'))
        <div class="mt-6 p-6 bg-white rounded-md shadow-md text-center text-gray-500">
            Tidak ada siswa yang ditemukan di kelas ini atau data filter tidak lengkap.
        </div>
    @endif
</div>

<!-- CDN untuk jsPDF, jsPDF-AutoTable, dan SheetJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const exportPdfBtn = document.getElementById('export-pdf');
    const exportExcelBtn = document.getElementById('export-excel');

    if (exportPdfBtn) {
        exportPdfBtn.addEventListener('click', generatePDF);
    }
    if (exportExcelBtn) {
        exportExcelBtn.addEventListener('click', generateExcel);
    }

    function getAttendanceData() {
        const table = document.getElementById('absensi-table');
        const rows = table.querySelectorAll('tbody tr');
        const data = [];
        rows.forEach(row => {
            const name = row.querySelector('td:first-child').dataset.name;
            const checkedRadio = row.querySelector('input[type="radio"]:checked');
            const status = checkedRadio ? checkedRadio.value : 'Tidak Diisi';
            data.push({ name, status });
        });
        return data;
    }

    function generatePDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        const attendanceData = getAttendanceData();
        const tableData = attendanceData.map(item => [item.name, item.status]);

        const kelas = document.getElementById('kelas_id').options[document.getElementById('kelas_id').selectedIndex].text;
        const tanggal = document.getElementById('tanggal_absensi').value;

        doc.setFontSize(18);
        doc.text(`Laporan Absensi - ${kelas}`, 14, 22);
        doc.setFontSize(12);
        doc.text(`Tanggal: ${tanggal}`, 14, 30);

        doc.autoTable({
            startY: 35,
            head: [['Nama Lengkap', 'Status Kehadiran']],
            body: tableData,
        });

        doc.save(`absensi-${kelas}-${tanggal}.pdf`);
    }

    function generateExcel() {
        const attendanceData = getAttendanceData();
        const worksheet = XLSX.utils.json_to_sheet(attendanceData.map(item => {
            return {
                'Nama Lengkap': item.name,
                'Status Kehadiran': item.status
            }
        }));
        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, 'Absensi');

        const kelas = document.getElementById('kelas_id').options[document.getElementById('kelas_id').selectedIndex].text;
        const tanggal = document.getElementById('tanggal_absensi').value;

        XLSX.writeFile(workbook, `absensi-${kelas}-${tanggal}.xlsx`);
    }
});
</script>
@endsection
