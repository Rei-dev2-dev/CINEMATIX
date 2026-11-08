@extends('layouts.app')

@section('title', 'Pilih Kursi - ' . $schedule->film->title . ' - CINEMATIX')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <!-- Header Title & Schedule Details -->
    <div>
        <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
            {{ $schedule->film->title }}
        </h1>
        <p class="text-sm text-[#B3B3B3] mt-1">
            {{ $schedule->studio_name }} · {{ \Carbon\Carbon::parse($schedule->show_date)->locale('id')->isoFormat('dddd, D MMM Y') }} · {{ $schedule->show_time }}
        </p>
    </div>

    <!-- Error notice from server validation if any -->
    @if ($errors->any())
        <div class="bg-red-950/80 border border-[#E50914] text-red-200 px-4 py-3 rounded-[5px] text-sm space-y-1">
            @foreach ($errors->all() as $error)
                <p>• {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <!-- Two-column grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- Left: Interactive Seat Map (Vanilla JS) -->
        <div class="lg:col-span-8 bg-[#1B1B1B] border border-[#262626] rounded-[6px] p-6 sm:p-8 flex flex-col items-center shadow-lg">

            <!-- Cinema Screen Indicator -->
            <div class="w-full max-w-xl mx-auto mb-10 flex flex-col items-center">
                <div class="w-full h-1.5 bg-[#444444] rounded-full shadow-[0_4px_16px_rgba(255,255,255,0.1)]"></div>
                <span class="text-[11px] font-bold tracking-[0.25em] text-[#777777] mt-3">LAYAR</span>
            </div>

            <!-- Seat Grid Container -->
            <div id="seat-map" data-price="{{ $schedule->price }}" class="w-full max-w-2xl overflow-x-auto pb-4">
                <div class="min-w-[480px] space-y-3 mx-auto">

                    <!-- Row A -->
                    <div class="flex items-center justify-center gap-2">
                        <span class="w-5 text-xs font-bold text-[#888888] text-right mr-2">A</span>
                        <!-- Left Block: A1 to A4 -->
                        <div class="flex gap-1.5 sm:gap-2">
                            @foreach(['A1','A2','A3','A4'] as $seat)
                                @php $isBooked = in_array($seat, $bookedSeats); @endphp
                                <button
                                    type="button"
                                    data-seat="{{ $seat }}"
                                    class="seat-btn w-7 h-7 sm:w-8 sm:h-8 rounded-[4px] text-[11px] font-bold flex items-center justify-center transition-all duration-150 {{ $isBooked ? 'seat-occupied' : 'seat-available' }}"
                                    title="Kursi {{ $seat }}{{ $isBooked ? ' (Terisi)' : '' }}"
                                    {{ $isBooked ? 'disabled' : '' }}
                                ></button>
                            @endforeach
                        </div>

                        <!-- Aisle gap -->
                        <div class="w-6 sm:w-8"></div>

                        <!-- Right Block: A5 to A8 -->
                        <div class="flex gap-1.5 sm:gap-2">
                            @foreach(['A5','A6','A7','A8'] as $seat)
                                @php $isBooked = in_array($seat, $bookedSeats); @endphp
                                <button
                                    type="button"
                                    data-seat="{{ $seat }}"
                                    class="seat-btn w-7 h-7 sm:w-8 sm:h-8 rounded-[4px] text-[11px] font-bold flex items-center justify-center transition-all duration-150 {{ $isBooked ? 'seat-occupied' : 'seat-available' }}"
                                    title="Kursi {{ $seat }}{{ $isBooked ? ' (Terisi)' : '' }}"
                                    {{ $isBooked ? 'disabled' : '' }}
                                ></button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Row B -->
                    <div class="flex items-center justify-center gap-2">
                        <span class="w-5 text-xs font-bold text-[#888888] text-right mr-2">B</span>
                        <!-- Left Block: B1 to B4 -->
                        <div class="flex gap-1.5 sm:gap-2">
                            @foreach(['B1','B2','B3','B4'] as $seat)
                                @php $isBooked = in_array($seat, $bookedSeats); @endphp
                                <button
                                    type="button"
                                    data-seat="{{ $seat }}"
                                    class="seat-btn w-7 h-7 sm:w-8 sm:h-8 rounded-[4px] text-[11px] font-bold flex items-center justify-center transition-all duration-150 {{ $isBooked ? 'seat-occupied' : 'seat-available' }}"
                                    title="Kursi {{ $seat }}{{ $isBooked ? ' (Terisi)' : '' }}"
                                    {{ $isBooked ? 'disabled' : '' }}
                                ></button>
                            @endforeach
                        </div>

                        <!-- Aisle gap -->
                        <div class="w-6 sm:w-8"></div>

                        <!-- Right Block: B5 to B8 -->
                        <div class="flex gap-1.5 sm:gap-2">
                            @foreach(['B5','B6','B7','B8'] as $seat)
                                @php $isBooked = in_array($seat, $bookedSeats); @endphp
                                <button
                                    type="button"
                                    data-seat="{{ $seat }}"
                                    class="seat-btn w-7 h-7 sm:w-8 sm:h-8 rounded-[4px] text-[11px] font-bold flex items-center justify-center transition-all duration-150 {{ $isBooked ? 'seat-occupied' : 'seat-available' }}"
                                    title="Kursi {{ $seat }}{{ $isBooked ? ' (Terisi)' : '' }}"
                                    {{ $isBooked ? 'disabled' : '' }}
                                ></button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Row C (Spans wider matching screenshot design) -->
                    <div class="flex items-center justify-center gap-2">
                        <span class="w-5 text-xs font-bold text-[#888888] text-right mr-2">C</span>
                        <!-- Left Outer: C1, C2 -->
                        <div class="flex gap-1.5 sm:gap-2">
                            @foreach(['C1','C2','C3','C4'] as $seat)
                                @php $isBooked = in_array($seat, $bookedSeats); @endphp
                                <button
                                    type="button"
                                    data-seat="{{ $seat }}"
                                    class="seat-btn w-7 h-7 sm:w-8 sm:h-8 rounded-[4px] text-[11px] font-bold flex items-center justify-center transition-all duration-150 {{ $isBooked ? 'seat-occupied' : 'seat-available' }}"
                                    title="Kursi {{ $seat }}{{ $isBooked ? ' (Terisi)' : '' }}"
                                    {{ $isBooked ? 'disabled' : '' }}
                                ></button>
                            @endforeach
                        </div>

                        <!-- Gap -->
                        <div class="w-6 sm:w-8"></div>

                        <!-- Right Outer: C7, C8, C9, C10 -->
                        <div class="flex gap-1.5 sm:gap-2">
                            @foreach(['C7','C8','C9','C10'] as $seat)
                                @php $isBooked = in_array($seat, $bookedSeats); @endphp
                                <button
                                    type="button"
                                    data-seat="{{ $seat }}"
                                    class="seat-btn w-7 h-7 sm:w-8 sm:h-8 rounded-[4px] text-[11px] font-bold flex items-center justify-center transition-all duration-150 {{ $isBooked ? 'seat-occupied' : 'seat-available' }}"
                                    title="Kursi {{ $seat }}{{ $isBooked ? ' (Terisi)' : '' }}"
                                    {{ $isBooked ? 'disabled' : '' }}
                                ></button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Row D -->
                    <div class="flex items-center justify-center gap-2">
                        <span class="w-5 text-xs font-bold text-[#888888] text-right mr-2">D</span>
                        <!-- Left Block: D1 to D4 -->
                        <div class="flex gap-1.5 sm:gap-2">
                            @foreach(['D1','D2','D3','D4'] as $seat)
                                @php $isBooked = in_array($seat, $bookedSeats); @endphp
                                <button
                                    type="button"
                                    data-seat="{{ $seat }}"
                                    class="seat-btn w-7 h-7 sm:w-8 sm:h-8 rounded-[4px] text-[11px] font-bold flex items-center justify-center transition-all duration-150 {{ $isBooked ? 'seat-occupied' : 'seat-available' }}"
                                    title="Kursi {{ $seat }}{{ $isBooked ? ' (Terisi)' : '' }}"
                                    {{ $isBooked ? 'disabled' : '' }}
                                ></button>
                            @endforeach
                        </div>

                        <!-- Aisle gap -->
                        <div class="w-6 sm:w-8"></div>

                        <!-- Right Block: D5 to D8 -->
                        <div class="flex gap-1.5 sm:gap-2">
                            @foreach(['D5','D6','D7','D8'] as $seat)
                                @php $isBooked = in_array($seat, $bookedSeats); @endphp
                                <button
                                    type="button"
                                    data-seat="{{ $seat }}"
                                    class="seat-btn w-7 h-7 sm:w-8 sm:h-8 rounded-[4px] text-[11px] font-bold flex items-center justify-center transition-all duration-150 {{ $isBooked ? 'seat-occupied' : 'seat-available' }}"
                                    title="Kursi {{ $seat }}{{ $isBooked ? ' (Terisi)' : '' }}"
                                    {{ $isBooked ? 'disabled' : '' }}
                                ></button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Row E -->
                    <div class="flex items-center justify-center gap-2">
                        <span class="w-5 text-xs font-bold text-[#888888] text-right mr-2">E</span>
                        <!-- Left Block: E1 to E4 -->
                        <div class="flex gap-1.5 sm:gap-2">
                            @foreach(['E1','E2','E3','E4'] as $seat)
                                @php $isBooked = in_array($seat, $bookedSeats); @endphp
                                <button
                                    type="button"
                                    data-seat="{{ $seat }}"
                                    class="seat-btn w-7 h-7 sm:w-8 sm:h-8 rounded-[4px] text-[11px] font-bold flex items-center justify-center transition-all duration-150 {{ $isBooked ? 'seat-occupied' : 'seat-available' }}"
                                    title="Kursi {{ $seat }}{{ $isBooked ? ' (Terisi)' : '' }}"
                                    {{ $isBooked ? 'disabled' : '' }}
                                ></button>
                            @endforeach
                        </div>

                        <!-- Aisle gap -->
                        <div class="w-6 sm:w-8"></div>

                        <!-- Right Block: E5 to E8 -->
                        <div class="flex gap-1.5 sm:gap-2">
                            @foreach(['E5','E6','E7','E8'] as $seat)
                                @php $isBooked = in_array($seat, $bookedSeats); @endphp
                                <button
                                    type="button"
                                    data-seat="{{ $seat }}"
                                    class="seat-btn w-7 h-7 sm:w-8 sm:h-8 rounded-[4px] text-[11px] font-bold flex items-center justify-center transition-all duration-150 {{ $isBooked ? 'seat-occupied' : 'seat-available' }}"
                                    title="Kursi {{ $seat }}{{ $isBooked ? ' (Terisi)' : '' }}"
                                    {{ $isBooked ? 'disabled' : '' }}
                                ></button>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>

            <!-- Seat Legend -->
            <div class="flex items-center justify-center gap-6 mt-8 pt-6 border-t border-[#262626] text-xs text-[#B3B3B3]">
                <div class="flex items-center gap-2">
                    <span class="w-4 h-4 rounded-[3px] bg-[#2A2A2A] border border-[#383838]"></span>
                    <span>Tersedia</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-4 h-4 rounded-[3px] bg-[#E50914]"></span>
                    <span>Dipilih</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-4 h-4 rounded-[3px] bg-[#0E0E0E] border border-[#1A1A1A]"></span>
                    <span>Terisi</span>
                </div>
            </div>

        </div>

        <!-- Right: Data Pemesan Form Card -->
        <div class="lg:col-span-4">
            <div class="bg-[#1F1F1F] border border-[#2A2A2A] rounded-[6px] p-6 space-y-6 shadow-xl">
                <h2 class="text-lg font-bold text-white">
                    Data Pemesan
                </h2>

                <form id="booking-form" action="{{ route('booking.store', $schedule->id) }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Customer Name -->
                    <div class="space-y-1.5">
                        <label for="customer_name" class="block text-xs font-semibold text-[#CCCCCC]">
                            Nama lengkap
                        </label>
                        <input 
                            type="text" 
                            id="customer_name" 
                            name="customer_name" 
                            value="{{ old('customer_name') }}"
                            placeholder="Nama sesuai KTP"
                            required
                            class="w-full bg-[#161616] border border-[#333333] focus:border-[#E50914] focus:ring-1 focus:ring-[#E50914] rounded-[5px] px-3.5 py-2.5 text-sm text-white placeholder-[#666666] outline-none transition"
                        >
                    </div>

                    <!-- Customer Email -->
                    <div class="space-y-1.5">
                        <label for="customer_email" class="block text-xs font-semibold text-[#CCCCCC]">
                            Email
                        </label>
                        <input 
                            type="email" 
                            id="customer_email" 
                            name="customer_email" 
                            value="{{ old('customer_email') }}"
                            placeholder="nama@email.com"
                            required
                            class="w-full bg-[#161616] border border-[#333333] focus:border-[#E50914] focus:ring-1 focus:ring-[#E50914] rounded-[5px] px-3.5 py-2.5 text-sm text-white placeholder-[#666666] outline-none transition"
                        >
                    </div>

                    <!-- Customer Phone -->
                    <div class="space-y-1.5">
                        <label for="customer_phone" class="block text-xs font-semibold text-[#CCCCCC]">
                            No. HP
                        </label>
                        <input 
                            type="tel" 
                            id="customer_phone" 
                            name="customer_phone" 
                            value="{{ old('customer_phone') }}"
                            placeholder="08xxxxxxxxxx"
                            required
                            class="w-full bg-[#161616] border border-[#333333] focus:border-[#E50914] focus:ring-1 focus:ring-[#E50914] rounded-[5px] px-3.5 py-2.5 text-sm text-white placeholder-[#666666] outline-none transition"
                        >
                    </div>

                    <!-- Dynamic Real-time Summary (Updated via vanilla JS) -->
                    <div class="pt-4 border-t border-[#2A2A2A] space-y-2 text-sm">
                        <div class="flex items-center justify-between text-[#B3B3B3]">
                            <span>Kursi</span>
                            <span id="selected-seats-display" class="font-bold text-white text-base">C3, C4</span>
                        </div>
                        <div class="flex items-center justify-between text-[#B3B3B3]">
                            <span>Total</span>
                            <span id="total-price-display" class="font-black text-white text-xl">Rp90.000</span>
                        </div>
                    </div>

                    <!-- Hidden input storing comma-separated seat codes (e.g. "C3,C4") -->
                    <input type="hidden" id="seats-input" name="seats" value="{{ old('seats', 'C3,C4') }}">

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        id="submit-booking-btn"
                        class="w-full bg-[#E50914] hover:bg-[#c40812] active:bg-[#a3060f] text-white font-bold py-3 px-4 rounded-[5px] transition shadow-md flex items-center justify-center gap-2 cursor-pointer"
                    >
                        <span>Lanjut ke Ringkasan</span>
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

<!-- Vanilla JS Seat Map Handler -->
<script src="{{ asset('js/booking.js') }}"></script>
@endsection
