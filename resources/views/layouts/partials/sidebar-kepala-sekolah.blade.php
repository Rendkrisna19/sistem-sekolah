<a href="{{ route('kepala-sekolah.dashboard') }}" class="flex items-center px-6 py-2 mt-4 transition-colors duration-200 transform {{ request()->routeIs('kepala-sekolah.dashboard') ? 'bg-gray-700 bg-opacity-50 text-gray-100' : 'text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100' }}">
    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z" /></svg>
    <span class="mx-3">Dashboard</span>
</a>

<span class="px-6 py-2 mt-4 text-xs text-gray-400 uppercase">Laporan</span>
<a href="{{ route('laporan.absensi.index') }}" class="flex items-center px-6 py-2 mt-2 transition-colors duration-200 transform {{ request()->routeIs('laporan.absensi.index') ? 'bg-gray-700 bg-opacity-50 text-gray-100' : 'text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100' }}">
    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
    <span class="mx-3">Laporan Absensi</span>
</a>
<a href="{{ route('laporan.nilai.index') }}" class="flex items-center px-6 py-2 mt-2 transition-colors duration-200 transform {{ request()->routeIs('laporan.nilai.index') ? 'bg-gray-700 bg-opacity-50 text-gray-100' : 'text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100' }}">
    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg>
    <span class="mx-3">Laporan Nilai</span>
</a>

<hr class="mx-6 my-4 border-gray-600">