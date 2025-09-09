<?php

namespace App\Repositories;

use App\Models\Training;
use Illuminate\Database\Eloquent\Collection;

class TrainingRepository
{
    public function all(): Collection
    {
        return Training::orderBy('date_from', 'desc')->get();
    }

    public function active(): Collection
    {
        return Training::active()->orderBy('date_from', 'asc')->get();
    }

    public function upcoming(): Collection
    {
        return Training::upcoming()->active()->orderBy('date_from', 'asc')->get();
    }

    public function ongoing(): Collection
    {
        return Training::ongoing()->active()->orderBy('date_from', 'asc')->get();
    }

    public function past(): Collection
    {
        return Training::past()->orderBy('date_from', 'desc')->get();
    }

    public function find(int $id): ?Training
    {
        return Training::find($id);
    }

    public function create(array $data): Training
    {
        return Training::create($data);
    }

    public function update(Training $training, array $data): bool
    {
        return $training->update($data);
    }

    public function delete(Training $training): bool
    {
        return $training->delete();
    }
} 