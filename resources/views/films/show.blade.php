@extends('layouts.app')

@section('title', $film->title . ' - Jadwal & Tiket CINEMATIX')

@section('content')
<div class="space-y-10">

    <!-- Top Banner Section with Backdrop Image -->
    <section class="relative bg-[#181818] border-b border-[#222222] py-12 md:py-16 overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img 
                src="{{ $film->banner_url }}" 
                alt="{{ $film->title }}" 
                class="w-full h-full object-cover opacity-25 blur-xs scale-105"
            >
            <div class="absolute inset-0 bg-gradient-to-r from-[#141414] via-[#141414]/90 to-[#141414]/60"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-center">
                
                <!-- Poster Column (Desktop) -->
                <div class="hidden md:block md:col-span-3">
                    <div class="aspect-[2/3] w-full rounded-[5px] overflow-hidden border border-[#333333] shadow-2xl bg-[#1F1F1F]">
                        <img 
                            src="{{ $film->poster_url }}" 
                            alt="{{ $film->title }}" 
                            class="w-full h-full object-cover"
                        >
                    </div>
                </div>

                <!-- Info Banner Column -->
                <div class="md:col-span-9 space-y-4">
                    <div class="flex items-center gap-3">
                        <span class="text-xs uppercase tracking-widest text-[#B3B3B3] font-bold">
                            {{ strtoupper($film->genre) }}
                        </span>
                        @if($film->status === 'coming_soon')
                            <span class="px-2 py-0.5 text-[11px] bg-[#333333] text-gray-200 rounded font-semibold">
                                Segera Hadir
                            </span>
                        @endif
                    </div>

                    <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-white tracking-tight leading-tight">
                        {{ $film->title }}
                    </h1>

                    <div class="flex flex-wrap items-center gap-2 text-sm text-[#B3B3B3] font-medium">
                        <span>{{ $film->duration }} mnt</span>
                        <span>·</span>
                        <span class="flex items-center gap-1 text-white">
                            <svg class="w-4 h-4 text-amber-400 fill-current" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            Rating {{ number_format($film->rating, 1) }}
                        </span>
                        <span>·</span>
                        <span class="px-1.5 py-0.5 text-xs bg-[#2A2A2A] text-white rounded font-medium">{{ $film->age_rating }}</span>
                    </div>

                    <div class="text-[#CCCCCC] text-sm md:text-base leading-relaxed space-y-2 pt-1 max-w-3xl">
                        <p>{{ $film->synopsis }}</p>
                    </div>

                    <div class="flex items-center gap-3 pt-3">
                        @if($film->status === 'now_showing')
                            <a 
                                href="#jadwal-tayang" 
                                class="inline-flex items-center justify-center bg-[#E50914] hover:bg-[#c40812] text-white font-semibold px-6 py-2.5 rounded-[5px] transition shadow-md"
                            >
                                Pesan Tiket
                            </a>
                        @endif

                        @if(!empty($film->trailer_url))
                            <button 
                                type="button" 
                                id="btn-open-trailer"
                                class="inline-flex items-center gap-2 justify-center bg-[#2A2A2A] hover:bg-[#383838] text-white font-medium px-5 py-2.5 rounded-[5px] transition cursor-pointer"
                            >
                                <svg class="w-4 h-4 fill-current text-[#E50914]" viewBox="0 0 20 20">
                                    <path d="M6.3 2.841A1.5 1.5 0 004 4.11v11.78a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                                </svg>
                                Putar Trailer
                            </button>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Main Content: Schedules & Film Info (Two-Column Layout) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            <!-- Left Column: Jadwal Tayang (2 cols span) -->
            <div id="jadwal-tayang" class="lg:col-span-2 space-y-6">
                <div>
                    <h2 class="text-xl md:text-2xl font-bold text-white tracking-tight">
                        Jadwal Tayang
                    </h2>
                    <p class="text-xs text-[#888888] mt-0.5">
                        @if($film->status === 'now_showing')
                            Pilih jam tayang untuk melanjutkan pemilihan kursi
                        @else
                            Film ini berstatus Segera Hadir. Tiket belum dapat dipesan saat ini.
                        @endif
                    </p>
                </div>

                @if($film->status === 'coming_soon')
                    <div class="bg-[#1F1F1F] rounded-[5px] p-8 text-center text-[#B3B3B3] text-sm border border-[#2a2a2a] space-y-2">
                        <p class="text-white font-semibold">Film Ini Akan Segera Hadir di Bioskop</p>
                        <p class="text-xs text-[#888888]">
                            Estimasi tanggal rilis: 
                            <span class="text-[#E50914] font-bold">
                                {{ \Carbon\Carbon::parse($film->release_date)->locale('id')->isoFormat('D MMMM Y') }}
                            </span>
                        </p>
                    </div>
                @elseif($groupedSchedules->isEmpty())
                    <div class="bg-[#1F1F1F] rounded-[5px] p-8 text-center text-[#B3B3B3] text-sm border border-[#2a2a2a]">
                        Belum ada jadwal tayang untuk film ini hari ini. Silakan periksa kembali nanti.
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($groupedSchedules as $studioName => $schedules)
                            @php
                                $firstSchedule = $schedules->first();
                            @endphp
                            <div class="bg-[#1F1F1F] border border-[#2a2a2a] rounded-[5px] p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-sm">
                                <div>
                                    <h3 class="text-base font-bold text-white">
                                        {{ $studioName }} · <span class="text-gray-300 font-medium">{{ $firstSchedule->studio_type }}</span>
                                    </h3>
                                    <p class="text-xs text-[#B3B3B3] mt-0.5">
                                        Rp{{ number_format($firstSchedule->price, 0, ',', '.') }} / kursi
                                    </p>
                                </div>

                                <!-- Time Badges -->
                                <div class="flex flex-wrap items-center gap-2">
                                    @foreach($schedules as $schedule)
                                        <a 
                                            href="{{ route('booking.create', $schedule->id) }}" 
                                            class="px-4 py-2 text-sm font-semibold rounded-[5px] transition text-center min-w-[70px]
                                                   {{ $loop->first ? 'bg-[#E50914] text-white hover:bg-[#c40812]' : 'bg-[#2A2A2A] text-white hover:bg-[#E50914] hover:text-white' }}"
                                            title="Pesan tiket untuk jam {{ $schedule->show_time }}"
                                        >
                                            {{ $schedule->show_time }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Right Column: Info Film (1 col span) -->
            <div class="space-y-6">
                <div class="bg-[#1F1F1F] border border-[#2a2a2a] rounded-[5px] p-6 space-y-4 shadow-sm">
                    <h3 class="text-lg font-bold text-white">
                        Info Film
                    </h3>

                    <div class="space-y-3 text-sm">
                        <div>
                            <span class="text-[#B3B3B3] block text-xs">Genre:</span>
                            <span class="text-white font-medium">{{ $film->genre }}</span>
                        </div>
                        <div>
                            <span class="text-[#B3B3B3] block text-xs">Durasi:</span>
                            <span class="text-white font-medium">{{ $film->duration }} menit</span>
                        </div>
                        <div>
                            <span class="text-[#B3B3B3] block text-xs">Rating:</span>
                            <span class="text-white font-medium flex items-center gap-1">
                                <span class="text-amber-400">★</span> {{ number_format($film->rating, 1) }} / 5.0
                            </span>
                        </div>
                        <div>
                            <span class="text-[#B3B3B3] block text-xs">Sutradara:</span>
                            <span class="text-white font-medium">{{ $film->director ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-[#B3B3B3] block text-xs">Pemeran:</span>
                            <span class="text-white font-medium leading-relaxed">{{ $film->cast ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-[#B3B3B3] block text-xs">Klasifikasi Usia:</span>
                            <span class="text-white font-medium">{{ $film->age_rating }}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal Trailer YouTube (Pure Vanilla JS) -->
    <div 
        id="trailer-modal" 
        class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/85 backdrop-blur-xs"
    >
        <div 
            class="bg-[#1F1F1F] border border-[#333333] rounded-[6px] max-w-3xl w-full p-5 space-y-4 shadow-2xl"
        >
            <div class="flex items-center justify-between">
                <h4 class="text-base sm:text-lg font-bold text-white">Trailer: {{ $film->title }}</h4>
                <button id="btn-close-trailer" type="button" class="text-[#B3B3B3] hover:text-white text-2xl font-bold leading-none cursor-pointer">&times;</button>
            </div>
            
            <div class="aspect-video bg-black rounded overflow-hidden border border-[#2A2A2A]">
                @if(!empty($film->youtube_embed_url))
                    <iframe 
                        id="trailer-iframe"
                        src="{{ $film->youtube_embed_url }}" 
                        data-src="{{ $film->youtube_embed_url }}"
                        title="YouTube trailer for {{ $film->title }}"
                        class="w-full h-full"
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                        allowfullscreen
                    ></iframe>
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center text-gray-400 p-6">
                        <p class="text-white font-semibold">Trailer YouTube tidak tersedia untuk film ini.</p>
                    </div>
                @endif
            </div>

            <div class="flex items-center justify-between text-xs text-[#888888]">
                <span>Tonton di YouTube</span>
                <button id="btn-close-trailer-footer" type="button" class="px-4 py-2 bg-[#2A2A2A] hover:bg-[#383838] text-white text-xs rounded-[5px] cursor-pointer">
                    Tutup
                </button>
            </div>
        </div>
    </div>

</div>

<!-- Vanilla JS for Trailer Modal -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('trailer-modal');
        const openBtn = document.getElementById('btn-open-trailer');
        const closeBtn = document.getElementById('btn-close-trailer');
        const closeFooterBtn = document.getElementById('btn-close-trailer-footer');
        const iframe = document.getElementById('trailer-iframe');

        function openModal() {
            if (modal) {
                modal.classList.remove('hidden');
                if (iframe && iframe.dataset.src) {
                    iframe.src = iframe.dataset.src;
                }
            }
        }

        function closeModal() {
            if (modal) {
                modal.classList.add('hidden');
                if (iframe) {
                    iframe.src = '';
                }
            }
        }

        if (openBtn) openBtn.addEventListener('click', openModal);
        if (closeBtn) closeBtn.addEventListener('click', closeModal);
        if (closeFooterBtn) closeFooterBtn.addEventListener('click', closeModal);

        if (modal) {
            modal.addEventListener('click', function (e) {
                if (e.target === modal) {
                    closeModal();
                }
            });
        }

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
                closeModal();
            }
        });
    });
</script>
@endsection
