<?php

namespace App\Console\Commands;

use App\Models\Film;
use App\Services\TmdbService;
use Illuminate\Console\Command;

class SyncTmdbFilms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tmdb:sync {title? : Judul film yang ingin disinkronkan}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sinkronisasi data film (sinopsis, genre, durasi, rating, poster) dari The Movie Database (TMDB)';

    /**
     * Execute the console command.
     */
    public function handle(TmdbService $tmdbService): int
    {
        $apiKey = config('services.tmdb.key');
        if (empty($apiKey)) {
            $this->warn('TMDB_API_KEY belum diisi di file .env.');
            $this->info('Dapatkan API key gratis di https://www.themoviedb.org/settings/api lalu tambahkan ke .env:');
            $this->line('TMDB_API_KEY=your_api_key_here');
            return Command::FAILURE;
        }

        $specificTitle = $this->argument('title');

        $films = $specificTitle 
            ? Film::where('title', 'like', "%{$specificTitle}%")->get()
            : Film::all();

        if ($films->isEmpty()) {
            $this->error('Film tidak ditemukan di database.');
            return Command::FAILURE;
        }

        $this->info("Memulai sinkronisasi " . $films->count() . " film dengan TMDB...");

        $successCount = 0;
        foreach ($films as $film) {
            $this->line("Mencari data untuk: <comment>{$film->title}</comment>...");
            $data = $tmdbService->findByTitle($film->title);

            if ($data) {
                $film->update([
                    'poster_path' => $data['poster_path'] ?? $film->poster_path,
                    'synopsis' => $data['sinopsis'] ?: $film->synopsis,
                    'genre' => $data['genre'] ?: $film->genre,
                    'duration' => $data['durasi_menit'] ?: $film->duration,
                    'rating' => $data['rating'] ?: $film->rating,
                ]);

                $this->info("✓ Berhasil diperbarui dari TMDB (ID: {$data['tmdb_id']})");
                $successCount++;
            } else {
                $this->warn("- Data tidak ditemukan di TMDB untuk judul \"{$film->title}\".");
            }
        }

        $this->info("Selesai! {$successCount} dari " . $films->count() . " film berhasil disinkronkan.");
        return Command::SUCCESS;
    }
}

