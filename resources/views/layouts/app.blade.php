<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Manajemen Sekolah Digital') }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Poppins', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-100">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-100">
        @auth
        <!-- Sidebar -->
        <aside
            class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform bg-gray-900 lg:translate-x-0 lg:static lg:inset-0"
            :class="{'translate-x-0 ease-out': sidebarOpen, '-translate-x-full ease-in': !sidebarOpen}"
        >
            <div class="flex items-center justify-center mt-8">
                <div class="flex items-center">
                    <span class="mx-2 text-2xl font-semibold text-white">Manajemen Sekolah</span>
                </div>
            </div>

            <!-- Navigasi dengan Indikator Aktif -->
            <nav class="mt-10">
                @if(Auth::user()->role == 'guru')
                    {{-- ### MENU UNTUK GURU ### --}}
                    @include('layouts.partials.sidebar-guru')
                @elseif(Auth::user()->role == 'kepala_sekolah')
                    {{-- ### MENU UNTUK KEPALA SEKOLAH ### --}}
                    @include('layouts.partials.sidebar-kepala-sekolah')
                @endif
            </nav>
        </aside>
        @endauth

        <!-- Kontainer Konten Utama -->
        <div class="flex flex-col flex-1 w-full">
            @auth
            <header class="flex items-center justify-between px-6 py-4 bg-white border-b-4 border-indigo-600">
                <div class="flex items-center">
                    <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                    </button>
                </div>
                
                <div class="flex items-center">
                    <span class="text-gray-700 mr-4">Selamat datang, {{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-indigo-600 hover:text-indigo-800">Logout</button>
                    </form>
                </div>
            </header>
            @endauth

            <!-- Area Konten yang Bisa di-scroll -->
            <main class="flex-1 overflow-x-auto overflow-y-auto bg-gray-100">
                <div class="container px-6 py-8 mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>
</html>
