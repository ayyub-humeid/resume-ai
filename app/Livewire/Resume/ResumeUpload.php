<?php

namespace App\Livewire\Resume;

use App\Models\Resume;
use App\Services\ResumeParserService;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

class ResumeUpload extends Component
{
    use WithFileUploads; // Enables file upload handling in Livewire

    public $resume_file; // Store uploaded file temporarily
    public $title = '';
    public $resumes = [];
    public $uploading = false; // Track upload progress
    public $message = ''; // Success/error message
    public $page = 'index';
    public $testCounter = 0; // Connection test counter

    public function incrementTest()
    {
        $this->testCounter++;
    }
    public function changePage()
    {
        
        $this->page == 'index'?$this->page = 'upload':$this->page = 'index';
    }

    public function mount()
    {
        // Load user's existing resumes
        $this->loadResumes();
        
    }

    // Reload resumes from database
    public function loadResumes()
    {
        $this->resumes = Resume::where('user_id', auth()->id())
            ->latest()
            ->get();
    }

    // Handle file upload submission
    public function submitResume()
    {
        // Validate file and title
        $this->validate([
            'resume_file' => 'required|file|mimes:pdf,doc,docx|max:5120',
            'title' => 'nullable|string|max:255',
        ]);

        $this->uploading = true;

        try {
            // Lazy login/creation of a test user if not authenticated (guest helper)
            if (!auth()->check()) {
                $user = \App\Models\User::firstOrCreate([
                    'email' => 'test@example.com',
                ], [
                    'name' => 'Test User',
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]);
                auth()->login($user);
            }

            // Store file in public disk
            $path = $this->resume_file->store('resumes', 'public');

            // Get full path for parsing
            $fullPath = storage_path('app/public/' . $path);

            // Resolve the parser service dynamically to avoid serialization issues
            $parserService = app(ResumeParserService::class);
            $rawText = $parserService->parse($fullPath);

            // Save to database
            Resume::create([
                'user_id' => auth()->id(),
                'file_name' => $this->resume_file->getClientOriginalName(),
                'file_path' => $path,
                'raw_text' => $rawText,
                'title' => $this->title ?: 'Resume ' . now()->format('M d, Y'),
            ]);

            // Reset form and reload list
            $this->reset(['resume_file', 'title']);
            $this->loadResumes();
           
            $this->dispatch('closeMessage');
            $this->page = 'index'; // Switch back to index page after upload
             $this->message = '✓ Resume uploaded successfully!';
            // Clear message after 3 seconds
            
        } catch (\Exception $e) {
            $this->message = '✗ Upload failed: ' . $e->getMessage();
        }

        $this->uploading = false;
    }

    // Delete resume
    public function delete($resumeId)
    {
        $resume = Resume::where('id', $resumeId)
            ->where('user_id', auth()->id())
            ->first();

        if ($resume) {
            // Delete file from storage
            \Storage::disk('public')->delete($resume->file_path);
            // Delete from database
            $resume->delete();
            $this->loadResumes();
            $this->message = '✓ Resume deleted!';
        }
    }

    public function render()
    {
        return view('components.resume.⚡resume-upload');
    }
}