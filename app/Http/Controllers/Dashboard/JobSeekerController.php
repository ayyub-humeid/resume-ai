<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Analysis;
use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class JobSeekerController extends Controller implements HasMiddleware
{
    // Ensure user is authenticated
  public static function middleware(): array
    {
        return [
            // 1. Applied to every method in this controller
            'auth',

            // 2. Applied only to specific methods
            // new Middleware('verified', only: ['applyForJob', 'updateProfile']),

            // 3. Applied to all methods EXCEPT public ones
            // new Middleware('log.activity', except: ['index', 'show']),
        ];
    }

    // Show Job Seeker Dashboard
    public function index()
    {
        $user = auth()->user();

        return view('dashboard.job-seeker.index', [
            'pageTitle' => 'Dashboard - Resume AI',
            'pageHeading' => 'Dashboard',
            'pageDescription' => 'Upload resumes, analyze jobs, and improve your profile',
            'user' => $user,
            'resumeCount' => Resume::where('user_id', $user->id)->count(),
            'analysisCount' => Analysis::where('user_id', $user->id)->count(),
            'averageScore' => Analysis::where('user_id', $user->id)->avg('match_score'),
        ]);
    }

    // Show Resume Analyze Page
    public function analyze()
    {
        return view('dashboard.job-seeker.analyze', [
            'pageTitle' => 'Analyze Resume - Resume AI',
            'pageHeading' => 'Analyze Your Resume',
            'pageDescription' => 'Get AI-powered insights and recommendations',
        ]);
    }

    // Show Analysis Results
    public function results($analysisId)
    {
        return view('dashboard.job-seeker.results', [
            'pageTitle' => 'Analysis Results - Resume AI',
            'pageHeading' => 'Your Analysis Results',
            'analysisId' => $analysisId,
        ]);
    }
}
