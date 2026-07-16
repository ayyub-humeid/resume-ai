<?php

namespace Tests\Feature;

use App\Livewire\Analysis\AnalysisManager;
use App\Models\Analysis;
use App\Models\JobListing;
use App\Models\Resume;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ConfirmationModalTest extends TestCase
{
    use RefreshDatabase;

    public function test_confirmation_payload_can_delete_an_analysis(): void
    {
        $user = User::factory()->create();

        $resume = Resume::create([
            'user_id' => $user->id,
            'file_name' => 'resume.pdf',
            'file_path' => 'resumes/resume.pdf',
            'raw_text' => 'Experienced backend developer',
            'title' => 'My Resume',
        ]);

        $job = JobListing::create([
            'user_id' => $user->id,
            'title' => 'Senior Backend Engineer',
            'company' => 'Acme',
            'description' => 'Build robust APIs and improve platform reliability for a growing startup.',
        ]);

        $analysis = Analysis::create([
            'user_id' => $user->id,
            'resume_id' => $resume->id,
            'job_id' => $job->id,
            'match_score' => 82,
        ]);

        Livewire::actingAs($user)
            ->test(AnalysisManager::class)
            ->call('askToDelete', $analysis->id)
            ->call('handleConfirmation', ['confirmed' => true]);

        $this->assertDatabaseMissing('analyses', ['id' => $analysis->id]);
        $this->assertDatabaseMissing('job_listings', ['id' => $job->id]);
    }
}
