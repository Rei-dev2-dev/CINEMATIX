<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CINEMATIX - Pemesanan Tiket Bioskop Online')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('/images/icon/logo-icon.png') }}">

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #141414;
            color: #FFFFFF;
        }
    </style>
</head>
<body class="bg-[#141414] text-white antialiased min-h-screen flex flex-col selection:bg-[#E50914] selection:text-white">

    <!-- Header Navigation -->
    <header class="no-print sticky top-0 z-50 bg-[#141414]/95 backdrop-blur-md border-b border-[#222222]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-18 flex items-center justify-between gap-4">
            <!-- Left: Logo & Nav items -->
            <div class="flex items-center gap-8">
                <a href="{{ route('home') }}" class="text-[#E50914] font-black text-2xl tracking-wider hover:opacity-90 transition">
                    CINEMATIX
                </a>

                <nav class="hidden md:flex items-center gap-6 text-sm font-medium">
                    <a href="{{ route('home') }}" class="transition hover:text-white {{ request()->routeIs('home') && !request('q') ? 'text-white font-semibold' : 'text-[#B3B3B3]' }}">
                        Beranda
                    </a>
                    <a href="{{ route('home') }}#sedang-tayang" class="text-[#B3B3B3] hover:text-white transition">
                        Film
                    </a>
                    <a href="{{ route('home') }}#segera-hadir" class="text-[#B3B3B3] hover:text-white transition">
                        Segera Hadir
                    </a>
                    <a href="{{ route('tiket.search') }}" class="transition hover:text-white {{ request()->routeIs('tiket.*') ? 'text-white font-semibold' : 'text-[#B3B3B3]' }}">
                        Tiket Saya
                    </a>
                </nav>
            </div>

            <!-- Right: Search Bar & Masuk -->
            <div class="flex items-center gap-3">
                <!-- Search Form (Desktop) -->
                <form id="desktop-search-form" action="{{ route('home') }}" method="GET" class="relative hidden sm:block">
                    <input 
                        type="text" 
                        id="desktop-search-input"
                        name="q" 
                        value="{{ request('q', '') }}"
                        placeholder="Cari judul film..." 
                        autocomplete="off"
                        class="w-48 md:w-64 bg-[#1F1F1F] text-white text-sm placeholder-[#777777] rounded-[5px] pl-3 pr-8 py-1.5 border border-[#333333] focus:outline-none focus:border-[#E50914] focus:ring-1 focus:ring-[#E50914] transition"
                    >
                    <button type="submit" class="absolute right-2.5 top-1/2 -translate-y-1/2 text-[#777777] hover:text-white transition cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/>
                        </svg>
                    </button>
                </form>

                <!-- Mobile search button -->
                <button id="mobile-search-toggle" type="button" class="sm:hidden p-2 text-[#B3B3B3] hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/>
                    </svg>
                </button>

                <!-- Masuk Button -->
                <button 
                    type="button" 
                    onclick="alert('Fitur login member akan segera hadir. Anda dapat langsung memesan tiket tanpa akun!')"
                    class="bg-[#E50914] hover:bg-[#c40812] text-white text-sm font-semibold px-5 py-1.5 rounded-[5px] transition shadow-sm cursor-pointer"
                >
                    Masuk
                </button>

                <!-- Mobile Menu Hamburger -->
                <button id="mobile-menu-toggle" type="button" class="md:hidden p-2 text-[#B3B3B3] hover:text-white focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile search dropdown -->
        <div id="mobile-search-container" class="hidden sm:hidden px-4 pb-3 pt-1 border-t border-[#222222]">
            <form id="mobile-search-form" action="{{ route('home') }}" method="GET" class="relative">
                <input 
                    type="text" 
                    id="mobile-search-input"
                    name="q" 
                    value="{{ request('q', '') }}"
                    placeholder="Cari judul film..." 
                    autocomplete="off"
                    class="w-full bg-[#1F1F1F] text-white text-sm placeholder-[#777777] rounded-[5px] pl-3 pr-9 py-2 border border-[#333333] focus:outline-none focus:border-[#E50914]"
                >
                <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-[#777777]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/>
                    </svg>
                </button>
            </form>
        </div>

        <!-- Mobile Nav Menu -->
        <div id="mobile-nav-menu" class="hidden md:hidden bg-[#181818] border-b border-[#2a2a2a] px-4 py-3 space-y-2">
            <a href="{{ route('home') }}" class="block py-2 text-sm text-[#B3B3B3] hover:text-white">Beranda</a>
            <a href="{{ route('home') }}#sedang-tayang" class="block py-2 text-sm text-[#B3B3B3] hover:text-white">Film Sedang Tayang</a>
            <a href="{{ route('home') }}#segera-hadir" class="block py-2 text-sm text-[#B3B3B3] hover:text-white">Segera Hadir</a>
            <a href="{{ route('tiket.search') }}" class="block py-2 text-sm text-[#B3B3B3] hover:text-white">Tiket Saya</a>
        </div>
    </header>

    <!-- Global Alert / Notification -->
    @if(session('success'))
        <div class="no-print max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-emerald-950/80 border border-emerald-600/50 text-emerald-200 px-4 py-3 rounded-[5px] flex items-center justify-between">
                <span>{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-white text-lg font-bold leading-none">&times;</button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="no-print max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-950/80 border border-[#E50914]/60 text-red-200 px-4 py-3 rounded-[5px] flex items-center justify-between">
                <span>{{ session('error') }}</span>
                <button onclick="this.parentElement.remove()" class="text-red-400 hover:text-white text-lg font-bold leading-none">&times;</button>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer with TMDB Attribution -->
    <footer class="no-print mt-20 border-t border-[#222222] bg-[#101010] py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6 text-xs text-[#888888]">
                <div class="flex items-center gap-3">
                    <span class="text-[#E50914] font-extrabold text-lg tracking-wider">CINEMATIX</span>
                    <span class="text-[#555555]">|</span>
                    <span>Platform Pemesanan Tiket Bioskop Online</span>
                </div>
                <div class="flex items-center gap-6">
                    <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
                    <a href="{{ route('home') }}#sedang-tayang" class="hover:text-white transition">Sedang Tayang</a>
                    <a href="{{ route('home') }}#segera-hadir" class="hover:text-white transition">Segera Hadir</a>
                    <a href="{{ route('tiket.search') }}" class="hover:text-white transition">Tiket Saya</a>
                </div>
                <div>
                    &copy; {{ date('Y') }} CINEMATIX. Hak cipta dilindungi undang-undang.
                </div>
            </div>

            <!-- Mandatory TMDB Attribution -->
            <div class="pt-4 border-t border-[#1C1C1C] flex flex-col sm:flex-row items-center justify-between gap-4 text-[11px] text-[#666666]">
                <div class="flex items-center gap-3">
                    <svg class="w-14 h-4 opacity-70" viewBox="0 0 200 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <text x="0" y="18" fill="#90cea1" font-family="sans-serif" font-weight="900" font-size="16">TMDB</text>
                    </svg>
                    <span>This product uses the TMDB API but is not endorsed or certified by TMDB. Data & poster film disediakan oleh The Movie Database (TMDB).</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Vanilla JS Navbar Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchBtn = document.getElementById('mobile-search-toggle');
            const searchContainer = document.getElementById('mobile-search-container');
            const menuBtn = document.getElementById('mobile-menu-toggle');
            const navMenu = document.getElementById('mobile-nav-menu');

            if (searchBtn && searchContainer) {
                searchBtn.addEventListener('click', function () {
                    searchContainer.classList.toggle('hidden');
                    const input = document.getElementById('mobile-search-input');
                    if (input && !searchContainer.classList.contains('hidden')) {
                        input.focus();
                    }
                });
            }

            if (menuBtn && navMenu) {
                menuBtn.addEventListener('click', function () {
                    navMenu.classList.toggle('hidden');
                });
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
