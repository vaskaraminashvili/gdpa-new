<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Applicant extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'training_id',
        'name',
        'personal_id',
        'phone',
        'certificate_number',
        'certificate_date',
        'specialty',
        'work_place',
        'work_place_address',
    ];

    protected $casts = [
        'certificate_date' => 'date',
    ];

    public function training(): BelongsTo
    {
        return $this->belongsTo(Training::class);
    }

    public function scopeForTraining($query, int $trainingId)
    {
        return $query->where('training_id', $trainingId);
    }
} 