<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'booking_code',
        'schedule_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'total_price',
        'status',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    /**
     * Get the schedule for this booking.
     *
     * @return BelongsTo<Schedule, $this>
     */
    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    /**
     * Get the seats reserved in this booking.
     *
     * @return HasMany<BookingSeat, $this>
     */
    public function seats(): HasMany
    {
        return $this->hasMany(BookingSeat::class);
    }

    /**
     * Aliases.
     */
    public function getKodeBookingAttribute(): string
    {
        return $this->booking_code;
    }

    public function getNamaAttribute(): string
    {
        return $this->customer_name;
    }

    public function getNoHpAttribute(): string
    {
        return $this->customer_phone;
    }

    public function getTotalAttribute(): mixed
    {
        return $this->total_price;
    }

    /**
     * Get comma-separated seat numbers.
     */
    public function getSeatsListAttribute(): string
    {
        return $this->seats->pluck('seat_number')->implode(', ');
    }
}
