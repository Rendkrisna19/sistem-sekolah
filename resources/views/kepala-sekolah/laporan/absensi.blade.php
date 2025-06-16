@extends('layouts.app')

@section('content')
<div>
    <h3 class="text-3xl font-medium text-gray-700">Laporan Absensi Siswa</h3>
    
    <!-- Filter Form -->
    <div class="mt-4 p-6 bg-white rounded-md shadow-md">
        <form action="{{ route('laporan.absensi.index') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="kelas_id" class="text-gray-700 font-semibold">Pilih Kelas</label>
                    <select name="kelas_id" id="kelas_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">-- Semua Kelas --</option>
                        @foreach ($kelasList as $kelas)
                            <option value="{{ $kelas->id }}" {{ $selectedKelasId == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="tanggal" class="text-gray-700 font-semibold">Pilih Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ $selectedTanggal ?? now()->format('Y-m-d') }}" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
                <div>
                    <label class="block text-transparent">.</label>
                    <button type="submit" class="w-full px-4 py-2 mt-1 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-indigo-600 rounded-md hover:bg-indigo-500 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-80">
                        Tampilkan Laporan
                    </button>
                </div>
            </div>
        </form>
    </div>

    @if($laporanAbsensi->isNotEmpty())
    <div class="mt-6">
        <div class="flex justify-end space-x-2 mb-4">
            <button onclick="generatePDF()" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-500 focus:outline-none focus:ring focus:ring-red-300 focus:ring-opacity-80">Cetak PDF</button>
            <button onclick="generateExcel()" class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-500 focus:outline-none focus:ring focus:ring-green-300 focus:ring-opacity-80">Export Excel</button>
        </div>
        <div class="overflow-x-auto -my-2 sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200" id="laporan-table">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">No</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Nama Siswa</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Dicatat oleh</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($laporanAbsensi as $index => $absensi)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $absensi->siswa->nama_lengkap ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @switch($absensi->status)
                                                @case('Hadir') bg-green-100 text-green-800 @break
                                                @case('Sakit') bg-yellow-100 text-yellow-800 @break
                                                @case('Izin') bg-blue-100 text-blue-800 @break
                                                @case('Alpa') bg-red-100 text-red-800 @break
                                            @endswitch">
                                            {{ $absensi->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $absensi->guru->user->name ?? 'N/A' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">Tidak ada data absensi untuk filter yang dipilih.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @elseif(request()->has('kelas_id'))
        <div class="mt-6 p-6 bg-white rounded-md shadow-md text-center text-gray-500">
            Tidak ada data absensi yang ditemukan untuk kelas dan tanggal yang dipilih.
        </div>
    @endif
</div>

<!-- CDN dan script untuk export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
    function getReportData() {
        const table = document.getElementById('laporan-table');
        const rows = table.querySelectorAll('tbody tr');
        const data = [];
        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            if (cells.length > 1) { // Pastikan bukan baris "Tidak ada data"
                const rowData = {
                    no: cells[0].innerText,
                    nama: cells[1].innerText,
                    status: cells[2].innerText,
                    dicatat_oleh: cells[3].innerText,
                };
                data.push(rowData);
            }
        });
        return data;
    }

    function generatePDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        const reportData = getReportData();
        const tableData = reportData.map(item => Object.values(item));

        const kelas = document.getElementById('kelas_id').options[document.getElementById('kelas_id').selectedIndex].text;
        const tanggal = document.getElementById('tanggal').value;
        const title = `Laporan Absensi Kelas ${kelas}`;
        const subtitle = `Tanggal: ${new Date(tanggal).toLocaleDateString('id-ID', { dateStyle: 'long' })}`;

        doc.setFontSize(18);
        doc.text(title, 14, 22);
        doc.setFontSize(12);
        doc.text(subtitle, 14, 30);

        doc.autoTable({
            startY: 35,
            head: [['No', 'Nama Siswa', 'Status', 'Dicatat Oleh']],
            body: tableData,
        });

        doc.save(`laporan-absensi-${kelas}-${tanggal}.pdf`);
    }

    function generateExcel() {
        const reportData = getReportData();
        const worksheet = XLSX.utils.json_to_sheet(reportData.map(item => {
            return {
                'No': item.no,
                'Nama Siswa': item.nama,
                'Status': item.status,
                'Dicatat Oleh': item.dicatat_oleh,
            }
        }));
        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, 'Laporan Absensi');

        const kelas = document.getElementById('kelas_id').options[document.getElementById('kelas_id').selectedIndex].text;
        const tanggal = document.getElementById('tanggal').value;

        XLSX.writeFile(workbook, `laporan-absensi-${kelas}-${tanggal}.xlsx`);
    }
</script>
@endsection
