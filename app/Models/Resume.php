<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Resume extends Model
{
    protected $fillable = [
        'user_id',
        'file_name',
        'file_path',
        'raw_text',
        'title',
    ];

    public function analyses(): HasMany { return $this->hasMany(Analysis::class); }
}
