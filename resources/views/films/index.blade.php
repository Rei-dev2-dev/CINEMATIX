@extends('layouts.app')

@section('title', 'CINEMATIX - Film Bioskop Terbaru & Jadwal Tayang')

@section('content')
<div class="space-y-10">

    <!-- Search Status Banner (Server-side or Live Filter) -->
    <div id="search-status-bar" class="{{ empty($search) ? 'hidden' : '' }} max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-[#1F1F1F] p-4 rounded-[5px] border border-[#333333] shadow-md">
            <div>
                <p class="text-sm text-[#CCCCCC]">
                    Hasil pencarian: <span id="search-keyword-display" class="font-bold text-white">"{{ $search }}"</span>
                    <span id="search-count-display" class="text-xs text-[#888888] ml-2">
                        ({{ $nowPlaying->count() + $comingSoon->count() }} film ditemukan)
                    </span>
                </p>
            </div>
            <button 
                type="button" 
                id="btn-clear-search"
                onclick="clearSearchFilter()"
                class="inline-flex items-center gap-1.5 text-xs text-[#E50914] hover:text-white font-semibold transition cursor-pointer self-start sm:self-auto"
            >
                <span>✕ Hapus Pencarian</span>
            </button>
        </div>
    </div>

    <!-- Hero / Featured Movie Banner (Hidden when user is actively searching) -->
    <div id="hero-banner-container" class="{{ !empty($search) ? 'hidden' : '' }}">
        @if($featuredFilm)
            <section class="relative bg-[#181818] border-b border-[#222222] overflow-hidden min-h-[420px] md:min-h-[480px] flex items-center">
                <!-- Background Image Banner with Dark Gradient Overlay -->
                <div class="absolute inset-0 z-0">
                    <img 
                        src="{{ $featuredFilm->banner_url }}" 
                        alt="{{ $featuredFilm->title }}" 
                        class="w-full h-full object-cover object-center opacity-30 blur-xs scale-105"
                    >
                    <div class="absolute inset-0 bg-gradient-to-r from-[#141414] via-[#141414]/90 to-transparent"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-[#141414] via-transparent to-transparent"></div>
                </div>

                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20 relative z-10 w-full">
                    <div class="max-w-2xl space-y-4">
                        <span class="inline-block text-xs uppercase tracking-widest text-[#B3B3B3] font-bold">
                            FILM UNGGULAN
                        </span>

                        <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-white tracking-tight leading-tight drop-shadow-md">
                            {{ $featuredFilm->title }}
                        </h1>

                        <div class="flex items-center gap-2 text-sm text-[#B3B3B3] font-medium">
                            <span>{{ $featuredFilm->genre }}</span>
                            <span>·</span>
                            <span>{{ $featuredFilm->duration }} mnt</span>
                            <span>·</span>
                            <span class="flex items-center gap-1 text-white">
                                <svg class="w-4 h-4 text-amber-400 fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                Rating {{ number_format($featuredFilm->rating, 1) }}
                            </span>
                            <span>·</span>
                            <span class="px-1.5 py-0.5 text-xs bg-[#2A2A2A] text-white rounded font-semibold">{{ $featuredFilm->age_rating }}</span>
                        </div>

                        <p class="text-[#CCCCCC] text-sm md:text-base leading-relaxed line-clamp-3">
                            {{ $featuredFilm->synopsis }}
                        </p>

                        <div class="flex items-center gap-3 pt-3">
                            <a 
                                href="{{ route('film.show', $featuredFilm->id) }}" 
                                class="inline-flex items-center justify-center bg-[#E50914] hover:bg-[#c40812] text-white font-semibold px-6 py-2.5 rounded-[5px] transition shadow-md"
                            >
                                Pesan Tiket
                            </a>
                            <a 
                                href="{{ route('film.show', $featuredFilm->id) }}" 
                                class="inline-flex items-center justify-center bg-[#2A2A2A] hover:bg-[#383838] text-white font-medium px-5 py-2.5 rounded-[5px] transition"
                            >
                                Info Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    </div>

    <!-- Main Movie Rows -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-14 pb-12">
        
        <!-- 1. Sedang Tayang (Now Showing) with Scroll Arrows -->
        <section id="sedang-tayang" class="relative">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <h2 class="text-xl md:text-2xl font-bold text-white tracking-tight">
                        Sedang Tayang
                    </h2>
                    <span id="now-showing-badge" class="text-xs text-[#888888] bg-[#1F1F1F] px-2 py-0.5 rounded border border-[#2A2A2A]">
                        {{ $nowPlaying->count() }} Film
                    </span>
                </div>

                <!-- Navigation Arrows (Header controls) -->
                <div class="flex items-center gap-2">
                    <button 
                        type="button" 
                        onclick="scrollCarousel('sedang-tayang-slider', -420)"
                        class="w-8 h-8 rounded-full bg-[#1F1F1F] hover:bg-[#E50914] text-white border border-[#333333] hover:border-[#E50914] flex items-center justify-center transition cursor-pointer"
                        title="Geser ke kiri"
                        aria-label="Geser ke kiri"
                    >
                        <svg class="w-4 h-4 stroke-current fill-none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <button 
                        type="button" 
                        onclick="scrollCarousel('sedang-tayang-slider', 420)"
                        class="w-8 h-8 rounded-full bg-[#1F1F1F] hover:bg-[#E50914] text-white border border-[#333333] hover:border-[#E50914] flex items-center justify-center transition cursor-pointer"
                        title="Geser ke kanan"
                        aria-label="Geser ke kanan"
                    >
                        <svg class="w-4 h-4 stroke-current fill-none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Empty Notice for Now Showing (Hidden by default or shown if 0) -->
            <div id="now-showing-empty" class="{{ $nowPlaying->isEmpty() ? '' : 'hidden' }} bg-[#1F1F1F] rounded-[5px] p-8 text-center text-[#B3B3B3] text-sm border border-[#2A2A2A]">
                Tidak ada film sedang tayang yang cocok dengan pencarian Anda.
            </div>

            <!-- Carousel Container with Floating Side Buttons -->
            <div id="now-showing-carousel-wrapper" class="relative group {{ $nowPlaying->isEmpty() ? 'hidden' : '' }}">
                <!-- Left Floating Arrow -->
                <button 
                    type="button"
                    onclick="scrollCarousel('sedang-tayang-slider', -420)"
                    class="hidden sm:flex absolute -left-4 top-1/2 -translate-y-1/2 z-30 w-11 h-11 rounded-full bg-black/80 hover:bg-[#E50914] text-white border border-[#3A3A3A] hover:border-[#E50914] items-center justify-center shadow-2xl transition cursor-pointer opacity-90 hover:opacity-100 hover:scale-110"
                    title="Geser ke kiri"
                >
                    <svg class="w-5 h-5 stroke-current fill-none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>

                <!-- Horizontal scrolling row with real posters -->
                <div 
                    id="sedang-tayang-slider" 
                    class="flex gap-4 overflow-x-auto pb-4 pt-1 scroll-smooth scrollbar-hide snap-x px-1"
                >
                    @foreach($nowPlaying as $film)
                        <a 
                            href="{{ route('film.show', $film->id) }}" 
                            class="movie-card group/card relative shrink-0 w-44 sm:w-52 aspect-[2/3] rounded-[5px] overflow-hidden bg-[#1F1F1F] border border-[#2A2A2A] hover:border-[#E50914] hover:scale-[1.02] transition-all duration-200 snap-start shadow-md flex flex-col justify-end p-4"
                            data-title="{{ strtolower($film->title) }}"
                            data-genre="{{ strtolower($film->genre) }}"
                            data-director="{{ strtolower($film->director ?? '') }}"
                            data-cast="{{ strtolower($film->cast ?? '') }}"
                            data-status="now_showing"
                        >
                            <!-- Poster Image -->
                            <img 
                                src="{{ $film->poster_url }}" 
                                alt="{{ $film->title }}" 
                                class="absolute inset-0 w-full h-full object-cover object-top group-hover/card:scale-105 transition duration-300"
                                loading="lazy"
                            >

                            <!-- Rating badge top right -->
                            <div class="absolute top-2.5 right-2.5 flex items-center gap-1 bg-black/75 backdrop-blur-xs px-2 py-0.5 rounded text-[11px] text-amber-400 font-semibold z-10">
                                <span>★</span>
                                <span>{{ number_format($film->rating, 1) }}</span>
                            </div>

                            <div class="absolute top-2.5 left-2.5 bg-[#E50914] px-1.5 py-0.5 rounded text-[10px] uppercase font-bold tracking-wider text-white z-10 shadow">
                                Tayang
                            </div>

                            <!-- Gradient overlay for title readability -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent z-10 pointer-events-none"></div>

                            <div class="relative z-20">
                                <h3 class="movie-title text-sm sm:text-base font-bold text-white group-hover/card:text-[#E50914] transition leading-snug line-clamp-2">
                                    {{ $film->title }}
                                </h3>
                                <p class="text-xs text-[#B3B3B3] mt-0.5 line-clamp-1">
                                    {{ $film->genre }} · {{ $film->duration }}m
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- Right Floating Arrow -->
                <button 
                    type="button"
                    onclick="scrollCarousel('sedang-tayang-slider', 420)"
                    class="hidden sm:flex absolute -right-4 top-1/2 -translate-y-1/2 z-30 w-11 h-11 rounded-full bg-black/80 hover:bg-[#E50914] text-white border border-[#3A3A3A] hover:border-[#E50914] items-center justify-center shadow-2xl transition cursor-pointer opacity-90 hover:opacity-100 hover:scale-110"
                    title="Geser ke kanan"
                >
                    <svg class="w-5 h-5 stroke-current fill-none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
        </section>

        <!-- 2. Segera Hadir (Coming Soon) with Scroll Arrows -->
        <section id="segera-hadir" class="relative">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <h2 class="text-xl md:text-2xl font-bold text-white tracking-tight">
                        Segera Hadir
                    </h2>
                    <span id="coming-soon-badge" class="text-xs text-[#888888] bg-[#1F1F1F] px-2 py-0.5 rounded border border-[#2A2A2A]">
                        {{ $comingSoon->count() }} Film
                    </span>
                </div>

                <!-- Navigation Arrows (Header controls) -->
                <div class="flex items-center gap-2">
                    <button 
                        type="button" 
                        onclick="scrollCarousel('segera-hadir-slider', -420)"
                        class="w-8 h-8 rounded-full bg-[#1F1F1F] hover:bg-[#E50914] text-white border border-[#333333] hover:border-[#E50914] flex items-center justify-center transition cursor-pointer"
                        title="Geser ke kiri"
                        aria-label="Geser ke kiri"
                    >
                        <svg class="w-4 h-4 stroke-current fill-none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <button 
                        type="button" 
                        onclick="scrollCarousel('segera-hadir-slider', 420)"
                        class="w-8 h-8 rounded-full bg-[#1F1F1F] hover:bg-[#E50914] text-white border border-[#333333] hover:border-[#E50914] flex items-center justify-center transition cursor-pointer"
                        title="Geser ke kanan"
                        aria-label="Geser ke kanan"
                    >
                        <svg class="w-4 h-4 stroke-current fill-none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Empty Notice for Coming Soon -->
            <div id="coming-soon-empty" class="{{ $comingSoon->isEmpty() ? '' : 'hidden' }} bg-[#1F1F1F] rounded-[5px] p-8 text-center text-[#B3B3B3] text-sm border border-[#2A2A2A]">
                Tidak ada film segera hadir yang cocok dengan pencarian Anda.
            </div>

            <!-- Carousel Container with Floating Side Buttons -->
            <div id="coming-soon-carousel-wrapper" class="relative group {{ $comingSoon->isEmpty() ? 'hidden' : '' }}">
                <!-- Left Floating Arrow -->
                <button 
                    type="button"
                    onclick="scrollCarousel('segera-hadir-slider', -420)"
                    class="hidden sm:flex absolute -left-4 top-1/2 -translate-y-1/2 z-30 w-11 h-11 rounded-full bg-black/80 hover:bg-[#E50914] text-white border border-[#3A3A3A] hover:border-[#E50914] items-center justify-center shadow-2xl transition cursor-pointer opacity-90 hover:opacity-100 hover:scale-110"
                    title="Geser ke kiri"
                >
                    <svg class="w-5 h-5 stroke-current fill-none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>

                <!-- Horizontal scrolling row with release date -->
                <div 
                    id="segera-hadir-slider" 
                    class="flex gap-4 overflow-x-auto pb-4 pt-1 scroll-smooth scrollbar-hide snap-x px-1"
                >
                    @foreach($comingSoon as $film)
                        <a 
                            href="{{ route('film.show', $film->id) }}" 
                            class="movie-card group/card relative shrink-0 w-44 sm:w-52 aspect-[2/3] rounded-[5px] overflow-hidden bg-[#1F1F1F] border border-[#2A2A2A] hover:border-[#888888] hover:scale-[1.02] transition-all duration-200 snap-start shadow-md flex flex-col justify-end p-4"
                            data-title="{{ strtolower($film->title) }}"
                            data-genre="{{ strtolower($film->genre) }}"
                            data-director="{{ strtolower($film->director ?? '') }}"
                            data-cast="{{ strtolower($film->cast ?? '') }}"
                            data-status="coming_soon"
                        >
                            <!-- Poster Image -->
                            <img 
                                src="{{ $film->poster_url }}" 
                                alt="{{ $film->title }}" 
                                class="absolute inset-0 w-full h-full object-cover object-top group-hover/card:scale-105 transition duration-300"
                                loading="lazy"
                            >

                            <!-- Coming soon badge -->
                            <div class="absolute top-2.5 left-2.5 bg-[#333333]/90 backdrop-blur-xs px-2 py-0.5 rounded text-[10px] uppercase font-semibold tracking-wider text-white z-10 shadow">
                                Segera Hadir
                            </div>

                            <!-- Release Date Badge top right -->
                            @if($film->release_date)
                                <div class="absolute top-2.5 right-2.5 bg-black/75 backdrop-blur-xs px-2 py-0.5 rounded text-[11px] text-gray-200 font-medium z-10">
                                    {{ \Carbon\Carbon::parse($film->release_date)->locale('id')->isoFormat('D MMM Y') }}
                                </div>
                            @endif

                            <!-- Gradient overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent z-10 pointer-events-none"></div>

                            <div class="relative z-20">
                                <h3 class="movie-title text-sm sm:text-base font-bold text-white group-hover/card:text-gray-200 transition leading-snug line-clamp-2">
                                    {{ $film->title }}
                                </h3>
                                <p class="text-xs text-[#E50914] font-medium mt-0.5">
                                    Tayang: {{ \Carbon\Carbon::parse($film->release_date)->locale('id')->isoFormat('D MMMM Y') }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- Right Floating Arrow -->
                <button 
                    type="button"
                    onclick="scrollCarousel('segera-hadir-slider', 420)"
                    class="hidden sm:flex absolute -right-4 top-1/2 -translate-y-1/2 z-30 w-11 h-11 rounded-full bg-black/80 hover:bg-[#E50914] text-white border border-[#3A3A3A] hover:border-[#E50914] items-center justify-center shadow-2xl transition cursor-pointer opacity-90 hover:opacity-100 hover:scale-110"
                    title="Geser ke kanan"
                >
                    <svg class="w-5 h-5 stroke-current fill-none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
        </section>
    </div>

</div>

<!-- Vanilla JS: Live Search & Carousel Slider -->
<script>
    function scrollCarousel(containerId, offset) {
        const container = document.getElementById(containerId);
        if (container) {
            container.scrollBy({
                left: offset,
                behavior: 'smooth'
            });
        }
    }

    function clearSearchFilter() {
        const desktopInput = document.getElementById('desktop-search-input');
        const mobileInput = document.getElementById('mobile-search-input');
        if (desktopInput) desktopInput.value = '';
        if (mobileInput) mobileInput.value = '';

        // If the URL currently has ?q=, navigate back cleanly to home
        if (window.location.search.includes('q=')) {
            window.location.href = "{{ route('home') }}";
            return;
        }

        // Otherwise filter in-place
        filterFilmsLive('');
    }

    function filterFilmsLive(rawQuery) {
        const q = rawQuery.trim().toLowerCase();
        const cards = document.querySelectorAll('.movie-card');
        const heroContainer = document.getElementById('hero-banner-container');
        const statusBar = document.getElementById('search-status-bar');
        const keywordDisplay = document.getElementById('search-keyword-display');
        const countDisplay = document.getElementById('search-count-display');

        const nowShowingBadge = document.getElementById('now-showing-badge');
        const comingSoonBadge = document.getElementById('coming-soon-badge');
        const nowShowingEmpty = document.getElementById('now-showing-empty');
        const comingSoonEmpty = document.getElementById('coming-soon-empty');
        const nowShowingWrapper = document.getElementById('now-showing-carousel-wrapper');
        const comingSoonWrapper = document.getElementById('coming-soon-carousel-wrapper');

        let matchNowShowing = 0;
        let matchComingSoon = 0;

        cards.forEach(card => {
            const title = card.getAttribute('data-title') || '';
            const genre = card.getAttribute('data-genre') || '';
            const director = card.getAttribute('data-director') || '';
            const cast = card.getAttribute('data-cast') || '';
            const status = card.getAttribute('data-status') || '';

            const isMatch = q === '' || 
                title.includes(q) || 
                genre.includes(q) || 
                director.includes(q) || 
                cast.includes(q);

            if (isMatch) {
                card.style.display = '';
                if (status === 'now_showing') matchNowShowing++;
                if (status === 'coming_soon') matchComingSoon++;
            } else {
                card.style.display = 'none';
            }
        });

        // Update counts & visibility
        if (nowShowingBadge) nowShowingBadge.textContent = matchNowShowing + ' Film';
        if (comingSoonBadge) comingSoonBadge.textContent = matchComingSoon + ' Film';

        if (nowShowingEmpty && nowShowingWrapper) {
            nowShowingEmpty.classList.toggle('hidden', matchNowShowing > 0);
            nowShowingWrapper.classList.toggle('hidden', matchNowShowing === 0);
        }

        if (comingSoonEmpty && comingSoonWrapper) {
            comingSoonEmpty.classList.toggle('hidden', matchComingSoon > 0);
            comingSoonWrapper.classList.toggle('hidden', matchComingSoon === 0);
        }

        // Toggle status bar and hero banner
        if (q !== '') {
            if (heroContainer) heroContainer.classList.add('hidden');
            if (statusBar) {
                statusBar.classList.remove('hidden');
                if (keywordDisplay) keywordDisplay.textContent = `"${rawQuery.trim()}"`;
                if (countDisplay) countDisplay.textContent = `(${matchNowShowing + matchComingSoon} film ditemukan)`;
            }
        } else {
            if (heroContainer) heroContainer.classList.remove('hidden');
            if (statusBar) statusBar.classList.add('hidden');
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const desktopInput = document.getElementById('desktop-search-input');
        const mobileInput = document.getElementById('mobile-search-input');

        if (desktopInput) {
            desktopInput.addEventListener('input', function (e) {
                const val = e.target.value;
                if (mobileInput) mobileInput.value = val;
                filterFilmsLive(val);
            });
        }

        if (mobileInput) {
            mobileInput.addEventListener('input', function (e) {
                const val = e.target.value;
                if (desktopInput) desktopInput.value = val;
                filterFilmsLive(val);
            });
        }
    });
</script>
@endsection
