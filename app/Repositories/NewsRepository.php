<?php

namespace App\Repositories;

use App\Models\News;
use Illuminate\Database\Eloquent\Collection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\DB;

class NewsRepository
{
    public function all(): Collection
    {
        return News::orderBy('created_at', 'desc')->get();
    }

    public function published(): Collection
    {
        return News::published()->orderBy('publish_date', 'desc')->get();
    }

    public function active(): Collection
    {
        return News::active()->orderBy('publish_date', 'desc')->get();
    }

    public function find(int $id): ?News
    {
        return News::find($id);
    }

    public function findBySlug(string $slug): ?News
    {
        return News::where('slug', $slug)->first();
    }

    public function create(array $data): News
    {
        return News::create($data);
    }

    public function update(News $news, array $data): bool
    {
        return $news->update($data);
    }

    public function delete(News $news): bool
    {
        return $news->delete();
    }
    public function importOldData(): void
    {
        $old_data = DB::table('news_copy1')
            ->orderBy('id', 'asc')->get();
        foreach ($old_data as $item) {
            $media = DB::table('media_copy1')->where('model_id', $item->id)->where('model_type', 'App\Models\News')->first();
            
            // Decode JSON strings to arrays before saving
            $title = is_string($item->title) ? json_decode($item->title, true) : $item->title;
            $description = is_string($item->description) ? json_decode($item->description, true) : $item->description;
            
            $news = News::create([
                'title' => $title,
                'description' => $description,
                'status' => $item->status,
                'publish_date' => $item->date,
            ]);
            DB::table('media_copy1_copy1')->where('model_id', $item->id)->update([
                'model_id' => $news->id,
                'model_type' => 'App\Models\News',
            ]);
        }
    }
} 