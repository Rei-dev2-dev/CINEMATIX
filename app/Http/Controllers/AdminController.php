<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Film;
use App\Models\Schedule;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Display admin overview dashboard with key metrics.
     */
    public function index(): View
    {
        $totalFilms = Film::count();
        $nowShowingCount = Film::where('status', 'now_showing')->count();
        $comingSoonCount = Film::where('status', 'coming_soon')->count();
        $totalBookings = Booking::count();
        $totalRevenue = Booking::sum('total_price');
        $recentBookings = Booking::with(['schedule.film', 'seats'])->latest()->take(8)->get();

        return view('admin.index', compact(
            'totalFilms',
            'nowShowingCount',
            'comingSoonCount',
            'totalBookings',
            'totalRevenue',
            'recentBookings'
        ));
    }

    /**
     * Display film management list.
     */
    public function films(): View
    {
        $films = Film::withCount('schedules')->latest()->get();
        return view('admin.films', compact('films'));
    }

    /**
     * Store a newly created film.
     */
    public function storeFilm(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'genre' => ['required', 'string', 'max:100'],
            'duration' => ['required', 'integer', 'min:1'],
            'rating' => ['required', 'numeric', 'min:0', 'max:5'],
            'age_rating' => ['required', 'string', 'max:10'],
            'director' => ['nullable', 'string', 'max:100'],
            'cast' => ['nullable', 'string', 'max:255'],
            'synopsis' => ['nullable', 'string'],
            'poster_url' => ['nullable', 'string'],
            'banner_url' => ['nullable', 'string'],
            'trailer_url' => ['nullable', 'string'],
            'status' => ['required', 'in:now_showing,coming_soon'],
            'release_date' => ['nullable', 'date'],
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(4);

        Film::create($validated);

        return redirect()->route('admin.films')->with('success', "Film \"{$validated['title']}\" berhasil ditambahkan!");
    }

    /**
     * Update an existing film (including YouTube trailer URL).
     */
    public function updateFilm(Request $request, int $id): RedirectResponse
    {
        $film = Film::findOrFail($id);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'genre' => ['required', 'string', 'max:100'],
            'duration' => ['required', 'integer', 'min:1'],
            'rating' => ['required', 'numeric', 'min:0', 'max:5'],
            'age_rating' => ['required', 'string', 'max:10'],
            'director' => ['nullable', 'string', 'max:100'],
            'cast' => ['nullable', 'string', 'max:255'],
            'synopsis' => ['nullable', 'string'],
            'poster_url' => ['nullable', 'string'],
            'banner_url' => ['nullable', 'string'],
            'trailer_url' => ['nullable', 'string'],
            'status' => ['required', 'in:now_showing,coming_soon'],
            'release_date' => ['nullable', 'date'],
        ]);

        $film->update($validated);

        return redirect()->route('admin.films')->with('success', "Data film \"{$film->title}\" berhasil diperbarui!");
    }

    /**
     * Delete a film.
     */
    public function deleteFilm(int $id): RedirectResponse
    {
        $film = Film::findOrFail($id);
        $title = $film->title;
        $film->delete();

        return redirect()->route('admin.films')->with('success', "Film \"{$title}\" berhasil dihapus.");
    }

    /**
     * Display schedule management.
     */
    public function schedules(): View
    {
        $films = Film::where('status', 'now_showing')->get();
        $schedules = Schedule::with('film')->orderBy('show_date', 'desc')->orderBy('show_time')->get();

        return view('admin.schedules', compact('films', 'schedules'));
    }

    /**
     * Store new schedule for a film.
     */
    public function storeSchedule(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'film_id' => ['required', 'exists:films,id'],
            'studio_name' => ['required', 'string', 'max:50'],
            'studio_type' => ['required', 'string', 'max:50'],
            'show_date' => ['required', 'date'],
            'show_time' => ['required', 'string', 'max:10'],
            'price' => ['required', 'numeric', 'min:1000'],
        ]);

        Schedule::create($validated);

        return redirect()->route('admin.schedules')->with('success', 'Jadwal tayang baru berhasil ditambahkan!');
    }

    /**
     * Delete a schedule.
     */
    public function deleteSchedule(int $id): RedirectResponse
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('admin.schedules')->with('success', 'Jadwal tayang berhasil dihapus.');
    }

    /**
     * Display bookings history.
     */
    public function bookings(): View
    {
        $bookings = Booking::with(['schedule.film', 'seats'])->latest()->get();
        return view('admin.bookings', compact('bookings'));
    }
}

