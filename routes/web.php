<?php

use App\Http\Controllers\Dashboard\JobSeeker\AnalysesController;
use App\Http\Controllers\Dashboard\JobSeeker\JobSeekerController;
use App\Http\Controllers\Dashboard\JobSeeker\ResumeController;
use App\Http\Controllers\Dashboard\Recruiter\RecruiterController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('home');
})->name('home');

// Authenticated routes with role-based middleware
Route::middleware(['auth'])->group(function () {


    // Job Seeker Dashboard Routes
    Route::middleware('job_seeker')
    ->prefix('dashboard/job-seeker')
    ->as('dashboard.job-seeker.')
    ->group(function () {
        Route::get('', [JobSeekerController::class, 'index'])->name('index');
        Route::get('/analyze', [AnalysesController::class, 'analyze'])->name('analyze');
        Route::get('/results/{analysisId}', [AnalysesController::class, 'results'])->name('results');
        Route::get('/resumes', [ResumeController::class, 'index'])->name('resumes.index');
        Route::post('/resumes', [ResumeController::class, 'store'])->name('resumes.store');
    });

    // Recruiter Dashboard Routes
    Route::middleware('recruiter')
    ->prefix('dashboard/recruiter')
    ->as('dashboard.recruiter.')
    ->group(function () {
        Route::get('', [RecruiterController::class, 'index'])->name('dashboard.recruiter.index');
        Route::get('/bulk-upload', [RecruiterController::class, 'bulkUpload'])->name('dashboard.recruiter.bulk-upload');
        Route::get('/candidates', [RecruiterController::class, 'candidates'])->name('dashboard.recruiter.candidates');
        Route::get('/compare/{candidateIds}', [RecruiterController::class, 'compare'])->name('dashboard.recruiter.compare');
    });
});