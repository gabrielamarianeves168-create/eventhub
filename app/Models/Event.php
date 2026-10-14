<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'description',
        'location',
        'start_at',
        'end_at',
        'capacity',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'start_at' => 'datetime',
            'end_at' => 'datetime',
            'capacity' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belogsTo(Category::class);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function isCanceled(): bool
    {
        return $this->status === 'canceled';
    }

    public function hasStarted(): bool
    {
        return $this->start_at->isPast();
    }
    
    public function hasFinished(): bool
    {
        return $this->end->end_at->isPast();
    }
}


