<?php
// app/Models/Film.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Film extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'slug',
        'genre',
        'duration',
        'rating',
        'age_rating',
        'director',
        'cast',
        'synopsis',
        'poster_color',
        'poster_path',
        'poster_url',
        'banner_url',
        'trailer_url',
        'status',
        'is_featured',
        'release_date',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'duration' => 'integer',
        'rating' => 'float',
        'is_featured' => 'boolean',
        'release_date' => 'date',
    ];

    /**
     * Get schedules for this film.
     *
     * @return HasMany<Schedule, $this>
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * Accessor for poster URL with 2:3 ratio placeholder fallback.
     */
    public function getPosterUrlAttribute(): string
    {
        $raw = $this->attributes['poster_url'] ?? null;
        if (! empty($raw)) {
            if (str_starts_with($raw, 'http://') || str_starts_with($raw, 'https://')) {
                return $raw;
            }
            return asset($raw);
        }

        if (! empty($this->attributes['poster_path'])) {
            return 'https://image.tmdb.org/t/p/w500' . $this->attributes['poster_path'];
        }

        // SVG placeholder with 2:3 ratio (400x600)
        return "data:image/svg+xml;charset=UTF-8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='400' height='600' viewBox='0 0 400 600'%3E%3Crect fill='%231F1F1F' width='400' height='600'/%3E%3Ctext fill='%23777777' font-family='sans-serif' font-size='22' font-weight='bold' x='50%25' y='50%25' text-anchor='middle' dy='.3em'%3EPoster Tidak Tersedia%3C/text%3E%3C/svg%3E";
    }

    /**
     * Accessor for banner / thumbnail URL with fallback to poster.
     */
    public function getBannerUrlAttribute(): string
    {
        $raw = $this->attributes['banner_url'] ?? null;
        if (! empty($raw)) {
            if (str_starts_with($raw, 'http://') || str_starts_with($raw, 'https://')) {
                return $raw;
            }
            return asset($raw);
        }

        return $this->poster_url;
    }

    /**
     * Accessor for sinopsis alias.
     */
    public function getSinopsisAttribute(): ?string
    {
        return $this->attributes['synopsis'] ?? null;
    }

    /**
     * Accessor for durasi_menit alias.
     */
    public function getDurasiMenitAttribute(): ?int
    {
        return $this->attributes['duration'] ?? null;
    }

    /**
     * Get embeddable YouTube trailer URL or direct link.
     */
    public function getYoutubeEmbedUrlAttribute(): ?string
    {
        $url = $this->attributes['trailer_url'] ?? null;
        if (! $url) {
            return null;
        }

        if (preg_match('/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))([\w-]{11})/', $url, $matches)) {
            return 'https://www.youtube-nocookie.com/embed/' . $matches[1] . '?autoplay=1';
        }

        return $url;
    }
}
