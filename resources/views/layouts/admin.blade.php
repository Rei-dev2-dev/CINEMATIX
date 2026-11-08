<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard - CINEMATIX')</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #141414;
            color: #FFFFFF;
        }
    </style>
</head>
<body class="bg-[#141414] text-white antialiased min-h-screen flex flex-col">

    <!-- Top Admin Header -->
    <header class="sticky top-0 z-50 bg-[#161616]/95 backdrop-blur-md border-b border-[#262626]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-6">
                <a href="{{ route('admin.index') }}" class="flex items-center gap-2">
                    <span class="text-[#E50914] font-black text-2xl tracking-wider">CINEMATIX</span>
                    <span class="bg-[#262626] text-[#B3B3B3] text-[10px] uppercase font-bold px-2 py-0.5 rounded tracking-wider">ADMIN</span>
                </a>

                <nav class="hidden md:flex items-center gap-5 text-sm font-medium">
                    <a href="{{ route('admin.index') }}" class="{{ request()->routeIs('admin.index') ? 'text-white font-semibold' : 'text-[#888888] hover:text-white' }} transition">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.films') }}" class="{{ request()->routeIs('admin.films*') ? 'text-white font-semibold' : 'text-[#888888] hover:text-white' }} transition">
                        Kelola Film
                    </a>
                    <a href="{{ route('admin.schedules') }}" class="{{ request()->routeIs('admin.schedules*') ? 'text-white font-semibold' : 'text-[#888888] hover:text-white' }} transition">
                        Jadwal Studio
                    </a>
                    <a href="{{ route('admin.bookings') }}" class="{{ request()->routeIs('admin.bookings*') ? 'text-white font-semibold' : 'text-[#888888] hover:text-white' }} transition">
                        Pemesanan Tiket
                    </a>
                </nav>
            </div>

            <div class="flex items-center gap-4">
                <a 
                    href="{{ route('home') }}" 
                    target="_blank"
                    class="text-xs bg-[#222222] hover:bg-[#333333] text-gray-200 px-3.5 py-1.5 rounded-[5px] transition flex items-center gap-1.5"
                >
                    <span>Lihat Website</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </a>
            </div>
        </div>
    </header>

    <!-- Alerts -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-emerald-950/80 border border-emerald-600/50 text-emerald-200 px-4 py-3 rounded-[5px] text-sm flex items-center justify-between shadow">
                <span>{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-white text-lg font-bold leading-none cursor-pointer">&times;</button>
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-950/80 border border-[#E50914] text-red-200 px-4 py-3 rounded-[5px] text-sm space-y-1 shadow">
                @foreach ($errors->all() as $error)
                    <p>• {{ $error }}</p>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="flex-1 py-8">
        @yield('content')
    </main>

    <footer class="border-t border-[#222222] bg-[#101010] py-6 text-center text-xs text-[#777777]">
        CINEMATIX Administration Panel &copy; {{ date('Y') }}
    </footer>

    @stack('scripts')
</body>
</html>

