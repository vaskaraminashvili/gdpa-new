<?php

namespace App\Repositories;

use App\Models\Gallery;
use Illuminate\Database\Eloquent\Collection;

class GalleryRepository
{
    public function all(): Collection
    {
        return Gallery::orderBy('sort', 'asc')->get();
    }

    public function active(): Collection
    {
        return Gallery::active()->ordered()->get();
    }

    public function find(int $id): ?Gallery
    {
        return Gallery::find($id);
    }

    public function create(array $data): Gallery
    {
        return Gallery::create($data);
    }

    public function update(Gallery $gallery, array $data): bool
    {
        return $gallery->update($data);
    }

    public function delete(Gallery $gallery): bool
    {
        return $gallery->delete();
    }

    public function getNextSortOrder(): int
    {
        $maxSort = Gallery::max('sort');
        return $maxSort ? $maxSort + 1 : 1;
    }

    public function reorder(array $sortOrder): bool
    {
        foreach ($sortOrder as $order => $id) {
            Gallery::where('id', $id)->update(['sort' => $order + 1]);
        }
        return true;
    }
} 