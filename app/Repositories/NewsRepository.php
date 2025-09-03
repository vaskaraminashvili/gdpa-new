<?php

namespace App\Repositories;

use App\Models\News;
use Illuminate\Database\Eloquent\Collection;

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
} 