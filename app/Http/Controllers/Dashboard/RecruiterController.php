<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class RecruiterController extends Controller implements HasMiddleware
{
    // Ensure user is authenticated
    public static function middleware(): array
    {
        return [
            'auth',
        ];
    }

    // Show Recruiter Dashboard
    public function index()
    {
        return view('dashboard.recruiter.index', [
            'pageTitle' => 'Recruiter Dashboard - Resume AI',
            'pageHeading' => 'Recruiter Dashboard',
            'pageDescription' => 'Bulk screen candidates and find top talent',
            'user' => auth()->user(),
        ]);
    }

    // Show Bulk Upload Page
    public function bulkUpload()
    {
        return view('dashboard.recruiter.bulk-upload', [
            'pageTitle' => 'Bulk Upload - Resume AI',
            'pageHeading' => 'Bulk Upload Resumes',
            'pageDescription' => 'Upload multiple resumes and a job description to rank candidates',
        ]);
    }

    // Show Candidate Rankings
    public function candidates()
    {
        return view('dashboard.recruiter.candidates', [
            'pageTitle' => 'Candidate Rankings - Resume AI',
            'pageHeading' => 'Candidate Rankings',
            'pageDescription' => 'View ranked candidates from your uploads',
        ]);
    }

    // Show Candidate Comparison
    public function compare($candidateIds)
    {
        return view('dashboard.recruiter.compare', [
            'pageTitle' => 'Compare Candidates - Resume AI',
            'pageHeading' => 'Compare Candidates',
            'candidateIds' => $candidateIds,
        ]);
    }
}
