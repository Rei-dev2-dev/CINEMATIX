@extends('layouts.app')

@section('title', 'E-Ticket: ' . $booking->booking_code . ' - CINEMATIX')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">

    <!-- Header notification -->
    <div class="no-print space-y-1">
        <h1 class="text-3xl font-black text-white tracking-tight">
            Pemesanan Berhasil
        </h1>
        <p class="text-sm text-[#B3B3B3]">
            Tunjukkan e-ticket ini di loket bioskop.
        </p>
    </div>

    <!-- Main E-Ticket Card -->
    <div class="print-ticket-container relative bg-[#1F1F1F] border border-[#2B2B2B] rounded-[6px] shadow-2xl overflow-hidden">
        <!-- Red top highlight border accent matching screenshot -->
        <div class="h-1 bg-[#E50914] w-full print-border-red"></div>

        <div class="p-6 sm:p-8 md:p-10 grid grid-cols-1 md:grid-cols-12 gap-8 items-center">
            
            <!-- Left Info Block (8 cols) -->
            <div class="md:col-span-7 lg:col-span-8 space-y-6">
                <!-- Film Title -->
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-[#888888] block">FILM</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-white mt-0.5">
                        {{ $booking->schedule->film->title }}
                    </h2>
                </div>

                <!-- Jadwal -->
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-[#888888] block">JADWAL</span>
                    <p class="text-sm sm:text-base text-gray-200 font-semibold mt-0.5">
                        {{ \Carbon\Carbon::parse($booking->schedule->show_date)->locale('id')->isoFormat('dddd, D MMM Y') }} · {{ $booking->schedule->show_time }} · {{ $booking->schedule->studio_name }}
                    </p>
                </div>

                <!-- Kursi -->
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-[#888888] block">KURSI</span>
                    <p class="text-base sm:text-lg font-black text-white mt-0.5 tracking-wide">
                        {{ $booking->seats_list }}
                    </p>
                </div>

                <!-- Pemesan -->
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-[#888888] block">PEMESAN</span>
                    <p class="text-sm text-gray-300 font-medium mt-0.5">
                        {{ $booking->customer_name }} · {{ $booking->customer_email }}
                    </p>
                    <p class="text-xs text-[#888888] mt-0.5">
                        {{ $booking->customer_phone }}
                    </p>
                </div>

                <!-- Total Bayar -->
                <div class="pt-2">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-[#888888] block">TOTAL BAYAR</span>
                    <p class="text-2xl sm:text-3xl font-black text-white mt-0.5">
                        Rp{{ number_format($booking->total_price, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <!-- Right QR Code & Booking Code Block (4-5 cols) -->
            <div class="md:col-span-5 lg:col-span-4 flex flex-col items-center justify-center p-4 border-t md:border-t-0 md:border-l border-[#2B2B2B] space-y-4 text-center">
                
                <!-- QR Code Box -->
                <div class="w-40 h-40 bg-white p-3 rounded-[4px] border-2 border-dashed border-[#444444] flex items-center justify-center shadow-inner">
                    <img src="{{ $qrCodeData }}" alt="QR Code {{ $booking->booking_code }}" class="w-full h-full object-contain">
                </div>

                <!-- Booking Code -->
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-widest text-[#888888] block">KODE BOOKING</span>
                    <span class="text-2xl sm:text-3xl font-black tracking-widest text-white block mt-1">
                        {{ $booking->booking_code }}
                    </span>
                    <span class="inline-block mt-2 px-2.5 py-0.5 text-[11px] font-semibold bg-emerald-950/80 text-emerald-400 border border-emerald-700/50 rounded">
                        LUNAS / TERKONFIRMASI
                    </span>
                </div>
            </div>

        </div>

        <!-- Cinema watermark / footer inside ticket -->
        <div class="bg-[#181818] px-6 sm:px-10 py-3 border-t border-[#262626] flex items-center justify-between text-xs text-[#777777]">
            <span class="font-bold text-[#E50914] tracking-wider">CINEMATIX TICKET</span>
            <span>Waktu pesan: {{ $booking->created_at->format('d/m/Y H:i') }} WIB</span>
        </div>
    </div>

    <!-- Action Buttons below ticket card -->
    <div class="no-print flex flex-wrap items-center gap-3 pt-2">
        <button 
            type="button" 
            onclick="window.print()"
            class="bg-[#E50914] hover:bg-[#c40812] active:bg-[#a3060f] text-white font-bold px-6 py-2.5 rounded-[5px] transition shadow-md flex items-center gap-2 cursor-pointer"
        >
            <svg class="w-4 h-4 fill-none stroke-current" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4H7v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            <span>Cetak Tiket</span>
        </button>

        <button 
            type="button" 
            onclick="window.print()"
            class="bg-[#2A2A2A] hover:bg-[#383838] text-white font-medium px-5 py-2.5 rounded-[5px] transition flex items-center gap-2 cursor-pointer"
        >
            <svg class="w-4 h-4 fill-none stroke-current" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
            <span>Unduh PDF</span>
        </button>

        <a 
            href="{{ route('home') }}" 
            class="bg-[#2A2A2A] hover:bg-[#383838] text-white font-medium px-5 py-2.5 rounded-[5px] transition"
        >
            Kembali ke Beranda
        </a>
    </div>

</div>
@endsection

