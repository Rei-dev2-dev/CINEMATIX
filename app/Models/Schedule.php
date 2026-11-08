<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Schedule extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'film_id',
        'studio_name',
        'studio_type',
        'show_date',
        'show_time',
        'price',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'show_date' => 'date',
        'price' => 'decimal:2',
    ];

    /**
     * Get the film for this schedule.
     *
     * @return BelongsTo<Film, $this>
     */
    public function film(): BelongsTo
    {
        return $this->belongsTo(Film::class);
    }

    /**
     * Get all bookings for this schedule.
     *
     * @return HasMany<Booking, $this>
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get all booked seats for this schedule.
     *
     * @return HasMany<BookingSeat, $this>
     */
    public function seats(): HasMany
    {
        return $this->hasMany(BookingSeat::class);
    }

    /**
     * Aliases for indonesian names.
     */
    public function getStudioAttribute(): string
    {
        return $this->studio_name;
    }

    public function getTanggalAttribute(): mixed
    {
        return $this->show_date;
    }

    public function getJamAttribute(): string
    {
        return $this->show_time;
    }

    public function getHargaAttribute(): mixed
    {
        return $this->price;
    }

    /**
     * Get array of booked seat numbers for this schedule.
     *
     * @return list<string>
     */
    public function getBookedSeatNumbers(): array
    {
        return $this->seats()->pluck('seat_number')->toArray();
    }
}
