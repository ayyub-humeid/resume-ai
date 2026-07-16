<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobListing extends Model
{
    protected $fillable = ['user_id', 'title', 'company', 'description', 'source_url', 'status'];

    public function analyses(): HasMany { return $this->hasMany(Analysis::class, 'job_id'); }
}
