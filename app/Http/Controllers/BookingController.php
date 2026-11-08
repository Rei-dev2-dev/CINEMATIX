<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingSeat;
use App\Models\Schedule;
use chillerlan\QRCode\QRCode;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    /**
     * Display the interactive booking page with seat map for a given schedule.
     */
    public function create(int $schedule_id): View
    {
        $schedule = Schedule::with('film')->findOrFail($schedule_id);

        /** @var list<string> $bookedSeats */
        $bookedSeats = $schedule->seats()->pluck('seat_number')->toArray();

        return view('bookings.create', compact('schedule', 'bookedSeats'));
    }

    /**
     * Process booking form submission, validate inputs and seat availability.
     */
    public function store(Request $request, int $schedule_id): RedirectResponse
    {
        $schedule = Schedule::with('film')->findOrFail($schedule_id);

        // Normalize seats input whether sent as comma-separated string ("C3,C4") or array
        $rawSeats = $request->input('seats');
        if (is_string($rawSeats)) {
            $parsedSeats = array_filter(array_map('trim', explode(',', $rawSeats)));
            $request->merge(['seats' => array_values($parsedSeats)]);
        }

        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'min:2', 'max:100'],
            'customer_email' => ['required', 'email', 'max:150'],
            'customer_phone' => ['required', 'string', 'min:8', 'max:20'],
            'seats' => ['required', 'array', 'min:1'],
            'seats.*' => ['required', 'string', 'max:10'],
        ], [
            'customer_name.required' => 'Nama lengkap wajib diisi sesuai KTP.',
            'customer_email.required' => 'Email wajib diisi untuk pengiriman e-ticket.',
            'customer_email.email' => 'Format email tidak valid.',
            'customer_phone.required' => 'Nomor HP wajib diisi.',
            'seats.required' => 'Pilih minimal satu kursi.',
            'seats.min' => 'Pilih minimal satu kursi.',
        ]);

        /** @var list<string> $selectedSeats */
        $selectedSeats = array_values(array_unique($validated['seats']));

        // Server-side check: Ensure none of the seats are already booked
        $alreadyBooked = BookingSeat::where('schedule_id', $schedule->id)
            ->whereIn('seat_number', $selectedSeats)
            ->pluck('seat_number')
            ->toArray();

        if (! empty($alreadyBooked)) {
            return back()->withInput()->withErrors([
                'seats' => 'Maaf, kursi ' . implode(', ', $alreadyBooked) . ' sudah dipesan oleh penonton lain. Silakan pilih kursi lain.',
            ]);
        }

        $totalPrice = count($selectedSeats) * (float) $schedule->price;

        // Generate unique booking code in format CNX-XXXXX (5 alphanumeric chars)
        do {
            $bookingCode = 'CNX-' . strtoupper(Str::random(5));
        } while (Booking::where('booking_code', $bookingCode)->exists());

        $booking = DB::transaction(function () use ($validated, $schedule, $bookingCode, $totalPrice, $selectedSeats): Booking {
            $booking = Booking::create([
                'booking_code' => $bookingCode,
                'schedule_id' => $schedule->id,
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'total_price' => $totalPrice,
                'status' => 'confirmed',
            ]);

            foreach ($selectedSeats as $seatNumber) {
                BookingSeat::create([
                    'booking_id' => $booking->id,
                    'schedule_id' => $schedule->id,
                    'seat_number' => $seatNumber,
                ]);
            }

            return $booking;
        });

        return redirect()->route('tiket.show', ['kode_booking' => $booking->booking_code])
            ->with('success', 'Pemesanan tiket berhasil!');
    }

    /**
     * Display E-Ticket page with summary, QR code, and print button.
     */
    public function showTicket(string $kode_booking): View
    {
        $booking = Booking::with(['schedule.film', 'seats'])
            ->where('booking_code', $kode_booking)
            ->firstOrFail();

        // Generate QR code data URL (SVG vector)
        $qrCodeData = (new QRCode)->render(route('tiket.show', ['kode_booking' => $booking->booking_code]));

        return view('bookings.ticket', compact('booking', 'qrCodeData'));
    }

    /**
     * Search ticket by booking code.
     */
    public function searchTicket(Request $request): View|RedirectResponse
    {
        $code = trim((string) $request->input('kode_booking', ''));

        if ($code !== '') {
            $booking = Booking::where('booking_code', $code)->first();
            if ($booking) {
                return redirect()->route('tiket.show', ['kode_booking' => $booking->booking_code]);
            }

            return back()->with('error', "Kode booking \"{$code}\" tidak ditemukan.");
        }

        return view('bookings.search');
    }
}
