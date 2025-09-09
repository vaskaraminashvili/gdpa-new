<?php

namespace App\Repositories;

use App\Models\Applicant;
use App\Models\Training;
use Illuminate\Database\Eloquent\Collection;

class ApplicantRepository
{
    public function all(): Collection
    {
        return Applicant::with('training')->orderBy('created_at', 'desc')->get();
    }

    public function forTraining(int $trainingId): Collection
    {
        return Applicant::forTraining($trainingId)->orderBy('created_at', 'desc')->get();
    }

    public function find(int $id): ?Applicant
    {
        return Applicant::with('training')->find($id);
    }

    public function findByPersonalId(string $personalId, int $trainingId): ?Applicant
    {
        return Applicant::where('personal_id', $personalId)
                       ->where('training_id', $trainingId)
                       ->first();
    }

    public function create(array $data): Applicant
    {
        return Applicant::create($data);
    }

    public function update(Applicant $applicant, array $data): bool
    {
        return $applicant->update($data);
    }

    public function delete(Applicant $applicant): bool
    {
        return $applicant->delete();
    }

    public function canApply(int $trainingId): bool
    {
        $training = Training::find($trainingId);
        if (!$training) {
            return false;
        }

        return $training->available_places > 0;
    }

    public function getApplicantCount(int $trainingId): int
    {
        return Applicant::forTraining($trainingId)->count();
    }
} 