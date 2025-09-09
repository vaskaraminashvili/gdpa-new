<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class Gallery extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, HasTranslations;

    protected $fillable = [
        'title',
        'status',
        'sort',
    ];

    protected $translatable = [
        'title',
    ];

    protected $casts = [
        'status' => 'boolean',
        'sort' => 'integer',
        'title' => 'array',
    ];

    // For the filament-sort-order package
    protected function getSortOrderAttribute()
    {
        return $this->sort;
    }

    protected function setSortOrderAttribute($value)
    {
        $this->sort = $value;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp']);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(200)
            ->sharpen(10);

        $this->addMediaConversion('medium')
            ->width(600)
            ->height(400)
            ->quality(90);

        $this->addMediaConversion('large')
            ->width(1200)
            ->height(800)
            ->quality(90);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort', 'asc');
    }
} 