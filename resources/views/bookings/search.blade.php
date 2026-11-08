@extends('layouts.app')

@section('title', 'Cari E-Ticket - CINEMATIX')

@section('content')
<div class="max-w-xl mx-auto px-4 sm:px-6 py-16 space-y-8">
    <div class="text-center space-y-2">
        <h1 class="text-3xl font-black text-white tracking-tight">
            Cek Tiket Saya
        </h1>
        <p class="text-sm text-[#B3B3B3]">
            Masukkan kode booking yang Anda terima saat melakukan pemesanan tiket.
        </p>
    </div>

    <div class="bg-[#1F1F1F] border border-[#2B2B2B] rounded-[6px] p-6 sm:p-8 space-y-6 shadow-xl">
        <form action="{{ route('tiket.search') }}" method="GET" class="space-y-4">
            <div>
                <label for="kode_booking" class="block text-xs font-semibold text-[#CCCCCC] mb-1.5 uppercase tracking-wider">
                    Kode Booking
                </label>
                <input 
                    type="text" 
                    id="kode_booking" 
                    name="kode_booking" 
                    value="{{ old('kode_booking', request('kode_booking')) }}" 
                    placeholder="Contoh: CNX-7K2Q9" 
                    required 
                    class="w-full bg-[#161616] border border-[#333333] focus:border-[#E50914] focus:ring-1 focus:ring-[#E50914] rounded-[5px] px-4 py-3 text-base font-mono tracking-widest text-white uppercase placeholder-[#555555] outline-none transition"
                >
                <p class="text-[11px] text-[#777777] mt-1.5">
                    Tip: Coba kode demo bawaan <span class="text-[#E50914] font-bold">CNX-7K2Q9</span>
                </p>
            </div>

            <button 
                type="submit" 
                class="w-full bg-[#E50914] hover:bg-[#c40812] text-white font-bold py-3 rounded-[5px] transition shadow-md flex items-center justify-center gap-2 cursor-pointer"
            >
                <svg class="w-4 h-4 fill-none stroke-current" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/>
                </svg>
                <span>Lihat E-Ticket</span>
            </button>
        </form>
    </div>

    <div class="text-center">
        <a href="{{ route('home') }}" class="text-sm text-[#888888] hover:text-white transition">
            ← Kembali ke Beranda
        </a>
    </div>
</div>
@endsection

