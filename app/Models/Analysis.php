<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Analysis extends Model
{
    protected $fillable = [
        'user_id', 'resume_id', 'job_id', 'match_score', 'keywords_matched',
        'keywords_missing', 'ats_issues', 'interview_questions', 'cover_letter', 'ai_response',
    ];

    protected function casts(): array
    {
        return [
            'keywords_matched' => 'array',
            'keywords_missing' => 'array',
            'ats_issues' => 'array',
            'interview_questions' => 'array',
        ];
    }

    public function resume(): BelongsTo { return $this->belongsTo(Resume::class); }
    public function job(): BelongsTo { return $this->belongsTo(JobListing::class, 'job_id'); }
}