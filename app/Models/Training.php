<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Training extends Model
{
    use SoftDeletes, HasTranslations;

    protected $fillable = [
        'title',
        'description',
        'date_from',
        'date_to',
        'status',
        'number_of_places',
    ];

    protected $translatable = [
        'title',
        'description',
    ];

    protected $casts = [
        'status' => 'boolean',
        'date_from' => 'datetime',
        'date_to' => 'datetime',
        'number_of_places' => 'integer',
        'title' => 'array',
        'description' => 'array',
    ];

    public function applicants(): HasMany
    {
        return $this->hasMany(Applicant::class);
    }

    public function getAvailablePlacesAttribute(): int
    {
        return $this->number_of_places - $this->applicants()->count();
    }

    public function getIsFullAttribute(): bool
    {
        return $this->available_places <= 0;
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('date_from', '>', now());
    }

    public function scopeOngoing($query)
    {
        return $query->where('date_from', '<=', now())
                    ->where('date_to', '>=', now());
    }

    public function scopePast($query)
    {
        return $query->where('date_to', '<', now());
    }

    public function scopeAvailable($query)
    {
        return $query->whereRaw('number_of_places > (SELECT COUNT(*) FROM applicants WHERE training_id = trainings.id AND deleted_at IS NULL)');
    }
} 