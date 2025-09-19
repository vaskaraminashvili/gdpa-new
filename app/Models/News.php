<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Str;
use Cviebrock\EloquentSluggable\Sluggable;

class News extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, HasTranslations, Sluggable;

    protected $fillable = [
        'title',
        'description',
        'status',
        'publish_date',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['description', 'title'],
                'maxLength' => 50,
                'separator' => '-',
                'unique' => true,
            ],
        ];
    }

    protected $translatable = [
        'title',
        'description',
    ];

    protected $casts = [
        'status' => 'boolean',
        'publish_date' => 'datetime',
        'title' => 'array',
        'description' => 'array',
    ];

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('news')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp'])
            ->singleFile();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('big-thumb')
            ->width(1680)
            ->height(815);

        $this->addMediaConversion('card-thumb')
            ->width(633)
            ->height(470);

        $this->addMediaConversion('small-thumb')
            ->width(300)
            ->height(100);
    }


    public function scopePublished($query)
    {
        return $query->where('status', true)
                    ->where('publish_date', '<=', now());
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
} 