<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Candidate extends Model
{
    protected $fillable = ['recruiter_id', 'job_id', 'name', 'email', 'file_name', 'file_path',
     'raw_text', 'match_score', 'status', 'review_state', 'review_data'];

    protected function casts(): array
    {
        return ['review_data' => 'array'];
    }

    public function job(): BelongsTo
    {
        return $this->belongsTo(JobListing::class, 'job_id');
    }
}