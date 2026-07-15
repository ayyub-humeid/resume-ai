<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use App\Services\ResumeParserService;
use Illuminate\Http\Request;

class ResumeController extends Controller
{
    // Inject the PDF parser service into the controller
    protected $parserService;

    public function __construct(ResumeParserService $parserService)
    {
        $this->parserService = $parserService;
    }

    // Show upload page
    // public function index()
    // {
    // Get all resumes for current user (we'll secure this with auth next)
    // $resumes = Resume::where('user_id', auth()->id())->get();
    // return view('resumes.index', compact('resumes'));

    // }
    public function index()
    {
        return view('resumes.index', [
            'pageTitle' => 'Resumes - Resume AI',
            'pageHeading' => 'Upload & Manage Resumes',
            'pageDescription' => 'Upload your resumes for AI-powered analysis and recruiter matching',
        ]);
    }
    // Handle file upload
    public function store(Request $request)
    {
        // Validate: accept PDF and DOCX files, max 5MB
        $validated = $request->validate([
            'resume_file' => 'required|file|mimes:pdf,doc,docx|max:5120',
            'title' => 'nullable|string|max:255',
        ]);

        // Store the file in storage/app/resumes directory
        $path = $request->file('resume_file')->store('resumes', 'public');

        // Get full file path for parsing
        $fullPath = storage_path('app/public/' . $path);

        // Parse the resume (extract text from PDF/DOCX)
        $rawText = $this->parserService->parse($fullPath);

        // Save to database with parsed content
        $resume = Resume::create([
            'user_id' => auth()->id(),
            'file_name' => $request->file('resume_file')->getClientOriginalName(),
            'file_path' => $path,
            'raw_text' => $rawText, // this is the extracted text we'll use for AI analysis
            'title' => $validated['title'] ?? 'Untitled Resume',
        ]);

        // Return JSON for Livewire to handle (we'll create Livewire component next)
        return response()->json([
            'success' => true,
            'resume' => $resume,
            'message' => 'Resume uploaded successfully!',
        ]);
    }
}