<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Film;
use App\Models\Schedule;
use Database\Seeders\FilmSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CinemaBookingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(FilmSeeder::class);
    }

    /**
     * Test home page displays featured film, now showing, and coming soon sections.
     */
    public function test_home_page_displays_featured_film_and_movie_sections(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('CINEMATIX');
        $response->assertSee('Sedang Tayang');
        $response->assertSee('Segera Hadir');
        $response->assertSee('Gak Ada Matinya');
        $response->assertSee('Avengers: Doomsday');
        $response->assertSee('TMDB');
    }

    /**
     * Test search functionality on home page.
     */
    public function test_home_page_search_filters_movies(): void
    {
        $response = $this->get('/?q=Godzilla');

        $response->assertStatus(200);
        $response->assertSee('Godzilla Minus One');
    }

    /**
     * Test film detail page loads with info and schedules.
     */
    public function test_film_detail_page_displays_info_and_schedules(): void
    {
        $film = Film::where('status', 'now_showing')->firstOrFail();

        $response = $this->get('/film/' . $film->id);

        $response->assertStatus(200);
        $response->assertSee($film->title);
        $response->assertSee('Jadwal Tayang');
        $response->assertSee('Info Film');
        $response->assertSee('Pesan Tiket');
    }

    /**
     * Test coming soon film does not display booking button.
     */
    public function test_coming_soon_film_does_not_have_booking_button(): void
    {
        $film = Film::where('status', 'coming_soon')->firstOrFail();

        $response = $this->get('/film/' . $film->id);

        $response->assertStatus(200);
        $response->assertSee($film->title);
        $response->assertSee('Segera Hadir');
        $response->assertDontSee('Pesan Tiket');
    }

    /**
     * Test booking page loads with seat map.
     */
    public function test_booking_page_displays_seat_map_and_schedules(): void
    {
        $schedule = Schedule::firstOrFail();

        $response = $this->get('/booking/' . $schedule->id);

        $response->assertStatus(200);
        $response->assertSee('LAYAR');
        $response->assertSee('Data Pemesan');
        $response->assertSee('Lanjut ke Ringkasan');
        $response->assertSee('js/booking.js');
    }

    /**
     * Test booking server-side validation.
     */
    public function test_booking_validation_fails_without_seats(): void
    {
        $schedule = Schedule::firstOrFail();

        $response = $this->post('/booking/' . $schedule->id, [
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'customer_phone' => '081234567890',
            'seats' => '',
        ]);

        $response->assertSessionHasErrors(['seats']);
    }

    /**
     * Test successfully booking tickets with comma-separated seat string.
     */
    public function test_booking_successfully_creates_booking_and_redirects_to_ticket(): void
    {
        $schedule = Schedule::where('show_time', '21.45')->firstOrFail();

        $response = $this->post('/booking/' . $schedule->id, [
            'customer_name' => 'Dewi Lestari',
            'customer_email' => 'dewi@example.com',
            'customer_phone' => '081234567899',
            'seats' => 'B1,B2',
        ]);

        $response->assertRedirect();

        $booking = Booking::where('customer_email', 'dewi@example.com')->latest()->first();
        $this->assertNotNull($booking);
        $this->assertCount(2, $booking->seats);
        $this->assertEquals($schedule->price * 2, (float) $booking->total_price);
        $this->assertStringStartsWith('CNX-', $booking->booking_code);

        $response->assertRedirect(route('tiket.show', ['kode_booking' => $booking->booking_code]));
    }

    /**
     * Test preventing double booking the same seat.
     */
    public function test_booking_prevents_double_booking_same_seat(): void
    {
        $schedule = Schedule::where('show_time', '21.45')->firstOrFail();

        // First booking succeeds
        $this->post('/booking/' . $schedule->id, [
            'customer_name' => 'User One',
            'customer_email' => 'user1@example.com',
            'customer_phone' => '081234567801',
            'seats' => 'E1',
        ])->assertRedirect();

        // Second booking for same seat fails
        $response = $this->post('/booking/' . $schedule->id, [
            'customer_name' => 'User Two',
            'customer_email' => 'user2@example.com',
            'customer_phone' => '081234567802',
            'seats' => 'E1',
        ]);

        $response->assertSessionHasErrors(['seats']);
    }

    /**
     * Test e-ticket page displays order summary and QR code.
     */
    public function test_ticket_page_displays_summary_and_qr_code(): void
    {
        $booking = Booking::firstOrFail();

        $response = $this->get('/tiket/' . $booking->booking_code);

        $response->assertStatus(200);
        $response->assertSee('Pemesanan Berhasil');
        $response->assertSee($booking->booking_code);
        $response->assertSee('KODE BOOKING');
        $response->assertSee('Cetak Tiket');
        $response->assertSee('data:image/svg+xml;base64', false);
    }

    /**
     * Test ticket search redirects to existing ticket.
     */
    public function test_ticket_search_redirects_to_valid_ticket(): void
    {
        $booking = Booking::firstOrFail();

        $response = $this->get('/tiket-saya?kode_booking=' . $booking->booking_code);

        $response->assertRedirect(route('tiket.show', ['kode_booking' => $booking->booking_code]));
    }
}
