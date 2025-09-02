<?php

namespace App\Models;

use IbrahimBougaoua\FilamentSortOrder\Traits\SortOrder;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class Slide extends Model implements HasMedia
{
    use InteractsWithMedia, HasTranslations, SortOrder;

    protected $fillable = [
        'status',
        'sort',
        'title',
        'description',
    ];

    protected $casts = [
        'status' => 'boolean',
        'sort' => 'integer',
        'title' => 'array',
        'description' => 'array',
    ];

    public $translatable = ['title', 'description'];

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
        $this->addMediaCollection('slides')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp'])
            ->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(200)
            ->sharpen(10);

        $this->addMediaConversion('large')
            ->width(1200)
            ->height(800)
            ->quality(90);
    }
}
