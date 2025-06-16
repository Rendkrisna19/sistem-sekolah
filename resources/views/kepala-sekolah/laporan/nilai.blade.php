@extends('layouts.app')

@section('content')
<div>
    <h3 class="text-3xl font-medium text-gray-700">Laporan Nilai Siswa</h3>

    <!-- Filter Form -->
    <div class="mt-4 p-6 bg-white rounded-md shadow-md">
        <form action="{{ route('laporan.nilai.index') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                    <label class="block text-transparent">.</label>
                    <button type="submit" class="w-full px-4 py-2 mt-1 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-indigo-600 rounded-md hover:bg-indigo-500 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-80">
                        Tampilkan Laporan
                    </button>
                </div>
            </div>
        </form>
    </div>

    @if($laporanNilai->isNotEmpty())
    <div class="mt-6">
        <div class="flex justify-end space-x-2 mb-4">
            <button onclick="generatePDF()" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-500 focus:outline-none focus:ring focus:ring-red-300 focus:ring-opacity-80">Cetak PDF</button>
        </div>
        <div id="laporan-container" class="space-y-6">
            @foreach($laporanNilai as $namaSiswa => $nilaiGroup)
                <div class="overflow-hidden border border-gray-200 shadow sm:rounded-lg">
                    <div class="px-4 py-3 bg-gray-50 border-b">
                        <h4 class="text-lg font-semibold text-gray-800">{{ $namaSiswa }}</h4>
                        <p class="text-sm text-gray-600">NIS: {{ $nilaiGroup->first()->siswa->nis ?? 'N/A' }}</p>
                    </div>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Nama Ujian</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Mata Pelajaran</th>
                                <th class="w-1/4 px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">Nilai</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                           @foreach($nilaiGroup as $nilai)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $nilai->ujian->nama_ujian ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $nilai->ujian->mataPelajaran->nama_mapel ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-center whitespace-nowrap font-semibold">{{ $nilai->nilai }}</td>
                            </tr>
                           @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>
    </div>
     @elseif(request()->has('kelas_id'))
        <div class="mt-6 p-6 bg-white rounded-md shadow-md text-center text-gray-500">
            Tidak ada data nilai yang ditemukan untuk kelas yang dipilih.
        </div>
    @endif
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
function generatePDF() {
    const { jsPDF } = window.jspdf;
    const reportContainer = document.getElementById('laporan-container');
    const kelas = document.getElementById('kelas_id').options[document.getElementById('kelas_id').selectedIndex].text;
    const doc = new jsPDF('p', 'mm', 'a4');
    
    // Header
    doc.setFontSize(18);
    doc.text(`Laporan Nilai Siswa - Kelas ${kelas}`, 14, 22);
    doc.setFontSize(11);
    doc.setTextColor(100);
    doc.text(`Dicetak pada: ${new Date().toLocaleDateString('id-ID', { dateStyle: 'full' })}`, 14, 29);

    html2canvas(reportContainer, { 
        scale: 2, // Meningkatkan resolusi
        useCORS: true 
    }).then(canvas => {
        const imgData = canvas.toDataURL('image/png');
        const imgProps= doc.getImageProperties(imgData);
        const pdfWidth = doc.internal.pageSize.getWidth() - 28; // a4 width - margin
        const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
        
        doc.addImage(imgData, 'PNG', 14, 40, pdfWidth, pdfHeight);
        
        doc.save(`laporan-nilai-${kelas}.pdf`);
    });
}
</script>
@endsection