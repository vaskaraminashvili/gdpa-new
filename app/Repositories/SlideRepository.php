<?php

namespace App\Repositories;

use App\Models\Slide;
use Illuminate\Database\Eloquent\Collection;

class SlideRepository
{
    public function __construct(
        protected Slide $model
    ) {}

    public function all(): Collection
    {
        return $this->model->orderBy('sort')->get();
    }

    public function active(): Collection
    {
        return $this->model->where('status', true)->orderBy('sort')->get();
    }

    public function find(int $id): ?Slide
    {
        return $this->model->find($id);
    }

    public function create(array $data): Slide
    {
        return $this->model->create($data);
    }

    public function update(Slide $slide, array $data): bool
    {
        return $slide->update($data);
    }

    public function delete(Slide $slide): bool
    {
        return $slide->delete();
    }

    public function getNextSortOrder(): int
    {
        return $this->model->max('sort') + 1;
    }

    public function reorder(array $sortedIds): void
    {
        foreach ($sortedIds as $index => $id) {
            $this->model->where('id', $id)->update(['sort' => $index + 1]);
        }
    }
} 