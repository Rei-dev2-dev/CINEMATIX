<?php
// app/Services/TmdbService.php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TmdbService
{
    private string $base = 'https://api.themoviedb.org/3';

    // Cari film berdasarkan judul, lalu ambil detail (durasi, genre) dalam bahasa Indonesia.
    // Return null kalau film tidak ditemukan di TMDB.
    public function findByTitle(string $title): ?array
    {
        $key = config('services.tmdb.key');

        $search = Http::get("{$this->base}/search/movie", [
            'api_key'  => $key,
            'query'    => $title,
            'language' => 'id-ID',
        ])->json('results');

        if (empty($search)) {
            return null;
        }

        $id = $search[0]['id'];

        $d = Http::get("{$this->base}/movie/{$id}", [
            'api_key'  => $key,
            'language' => 'id-ID',
        ])->json();

        return [
            'tmdb_id'     => $id,
            'poster_path' => $d['poster_path'] ?? null,
            'sinopsis'    => $d['overview'] ?? null,
            'genre'       => collect($d['genres'] ?? [])->pluck('name')->implode(', ') ?: null,
            'durasi_menit'=> $d['runtime'] ?? null,
            'rating'      => isset($d['vote_average']) ? round($d['vote_average'], 1) : null,
        ];
    }
}

