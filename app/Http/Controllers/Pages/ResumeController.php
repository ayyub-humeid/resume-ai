<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResumeController extends Controller
{
    // Middleware to ensure user is authenticated
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    // Show resumes upload page
    public function index()
    {
        return view('pages.resumes.index', [
            'pageTitle' => 'Resumes - Resume AI',
            'pageHeading' => 'Upload & Manage Resumes',
            'pageDescription' => 'Upload your resumes for AI-powered analysis and recruiter matching',
        ]);
    }
}