<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    /**
     * Display the home/catalog page with featured banner, now showing, and coming soon rows.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));

        $query = Film::query();
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('genre', 'like', "%{$search}%")
                    ->orWhere('director', 'like', "%{$search}%")
                    ->orWhere('cast', 'like', "%{$search}%")
                    ->orWhere('synopsis', 'like', "%{$search}%");
            });
        }

        $allFilms = $query->get();

        // If searching, hide static featured banner so search results are prominent at the top
        if ($search !== '') {
            $featuredFilm = null;
        } else {
            $featuredFilm = Film::where('status', 'now_showing')->where('is_featured', true)->first()
                ?? Film::where('status', 'now_showing')->first()
                ?? $allFilms->first();
        }

        $nowPlaying = $allFilms->where('status', 'now_showing');
        $comingSoon = $allFilms->where('status', 'coming_soon');

        return view('films.index', compact('featuredFilm', 'nowPlaying', 'comingSoon', 'search'));
    }

    /**
     * Display detail page of a specific film, including schedules and studio information.
     */
    public function show(int $id): View
    {
        $film = Film::with(['schedules' => function ($query) {
            $query->orderBy('studio_name')->orderBy('show_time');
        }])->findOrFail($id);

        /** @var \Illuminate\Support\Collection<string, \Illuminate\Support\Collection<int, \App\Models\Schedule>> $groupedSchedules */
        $groupedSchedules = $film->schedules->groupBy('studio_name');

        return view('films.show', compact('film', 'groupedSchedules'));
    }
}
