<?php

use App\Http\Controllers\Dashboard\JobSeekerController;
use App\Http\Controllers\Dashboard\RecruiterController;
use App\Http\Controllers\ResumeController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('home');
})->name('home');

// Authenticated routes with role-based middleware
Route::middleware(['auth'])->group(function () {
    Route::get('/resumes', [ResumeController::class, 'index'])->name('resumes.index');
    Route::post('/resumes', [ResumeController::class, 'store'])->name('resumes.store');

    // Job Seeker Dashboard Routes
    Route::middleware('job_seeker')
    ->prefix('dashboard/job-seeker')
    ->as('dashboard.job-seeker.')
    ->group(function () {
        Route::get('', [JobSeekerController::class, 'index'])->name('index');
        Route::get('/analyze', [JobSeekerController::class, 'analyze'])->name('analyze');
        Route::get('/results/{analysisId}', [JobSeekerController::class, 'results'])->name('results');
    });

    // Recruiter Dashboard Routes
    Route::middleware('recruiter')->group(function () {
        Route::get('/dashboard/recruiter', [RecruiterController::class, 'index'])->name('dashboard.recruiter.index');
        Route::get('/dashboard/recruiter/bulk-upload', [RecruiterController::class, 'bulkUpload'])->name('dashboard.recruiter.bulk-upload');
        Route::get('/dashboard/recruiter/candidates', [RecruiterController::class, 'candidates'])->name('dashboard.recruiter.candidates');
        Route::get('/dashboard/recruiter/compare/{candidateIds}', [RecruiterController::class, 'compare'])->name('dashboard.recruiter.compare');
    });
});