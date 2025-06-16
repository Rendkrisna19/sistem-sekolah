<a href="{{ route('dashboard.guru') }}" class="flex items-center px-6 py-2 mt-4 transition-colors duration-200 transform {{ request()->routeIs('dashboard.guru') ? 'bg-gray-700 bg-opacity-50 text-gray-100' : 'text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100' }}">
    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
    <span class="mx-3">Dashboard</span>
</a>

<span class="px-6 py-2 mt-4 text-xs text-gray-400 uppercase">Master Data</span>
<a href="{{ route('kelas.index') }}" class="flex items-center px-6 py-2 mt-2 transition-colors duration-200 transform {{ request()->routeIs('kelas.*') ? 'bg-gray-700 bg-opacity-50 text-gray-100' : 'text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100' }}">
    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h12A2.25 2.25 0 0 0 20.25 14.25V3.75M3.75 3h16.5M3.75 3v.75A2.25 2.25 0 0 1 1.5 6v.75m0 0v1.5m0 0v.75a2.25 2.25 0 0 0 2.25 2.25h1.5M12 16.5v.75m0 0v1.5m0 0v.75m0 0h1.5m-1.5 0h-1.5m-6-12v.75m0 0v1.5m0 0v.75a2.25 2.25 0 0 0 2.25 2.25h1.5M12 3v.75m0 0v1.5m0 0v.75a2.25 2.25 0 0 1-2.25 2.25h-1.5M12 3h1.5m-1.5 0h-1.5" /></svg>
    <span class="mx-3">Data Kelas</span>
</a>
<a href="{{ route('siswa.index') }}" class="flex items-center px-6 py-2 mt-2 transition-colors duration-200 transform {{ request()->routeIs('siswa.*') ? 'bg-gray-700 bg-opacity-50 text-gray-100' : 'text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100' }}">
    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
    <span class="mx-3">Data Siswa</span>
</a>
<a href="{{ route('guru.index') }}" class="flex items-center px-6 py-2 mt-2 transition-colors duration-200 transform {{ request()->routeIs('guru.*') ? 'bg-gray-700 bg-opacity-50 text-gray-100' : 'text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100' }}">
    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" /></svg>
    <span class="mx-3">Profil Guru</span>
</a>
<a href="{{ route('mapel.index') }}" class="flex items-center px-6 py-2 mt-2 transition-colors duration-200 transform {{ request()->routeIs('mapel.*') ? 'bg-gray-700 bg-opacity-50 text-gray-100' : 'text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100' }}">
    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" /></svg>
    <span class="mx-3">Mata Pelajaran</span>
</a>

<span class="px-6 py-2 mt-4 text-xs text-gray-400 uppercase">Akademik & Absensi</span>
<a href="{{ route('absensi.siswa.create') }}" class="flex items-center px-6 py-2 mt-2 transition-colors duration-200 transform {{ request()->routeIs('absensi.siswa.*') ? 'bg-gray-700 bg-opacity-50 text-gray-100' : 'text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100' }}">
    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
    <span class="mx-3">Absensi Siswa</span>
</a>
<a href="{{ route('jadwal.index') }}" class="flex items-center px-6 py-2 mt-2 transition-colors duration-200 transform {{ request()->routeIs('jadwal.*') ? 'bg-gray-700 bg-opacity-50 text-gray-100' : 'text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100' }}">
    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0h18" /></svg>
    <span class="mx-3">Jadwal Pelajaran</span>
</a>
<a href="{{ route('ujian.index') }}" class="flex items-center px-6 py-2 mt-2 transition-colors duration-200 transform {{ request()->routeIs('ujian.*') ? 'bg-gray-700 bg-opacity-50 text-gray-100' : 'text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100' }}">
    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>
    <span class="mx-3">Data Ujian</span>
</a>
<a href="{{ route('nilai.index') }}" class="flex items-center px-6 py-2 mt-2 transition-colors duration-200 transform {{ request()->routeIs('nilai.*') ? 'bg-gray-700 bg-opacity-50 text-gray-100' : 'text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100' }}">
    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg>
    <span class="mx-3">Input Nilai</span>
</a>
<a href="{{ route('raport.index') }}" class="flex items-center px-6 py-2 mt-2 transition-colors duration-200 transform {{ request()->routeIs('raport.*') ? 'bg-gray-700 bg-opacity-50 text-gray-100' : 'text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100' }}">
    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.627 48.627 0 0 1 12 20.904a48.627 48.627 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.57 50.57 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.902 59.902 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" /></svg>
    <span class="mx-3">Raport Siswa</span>
</a>

<hr class="mx-6 my-4 border-gray-600">