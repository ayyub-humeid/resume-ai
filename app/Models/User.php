<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password','role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    // Check if user is a Job Seeker
    public function isJobSeeker(): bool
    {
        return $this->role === 'job_seeker';
    }

    // Check if user is a Recruiter
    public function isRecruiter(): bool
    {
        return $this->role === 'recruiter';
    }

    // Get dashboard URL based on role
    public function getDashboardUrl(): string
    {
        return $this->isRecruiter()
            ? '/dashboard/recruiter'
            : '/dashboard/job-seeker';
    }
}
