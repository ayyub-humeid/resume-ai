<?php

namespace App\Services;

use App\Ai\Agents\ResumeAnalysisAgent;
use App\Models\Resume;
use Illuminate\Support\Arr;
use Laravel\Ai\Enums\Lab;
use RuntimeException;

class ResumeAnalysisService
{
    /** @return array<string, mixed> */
    public function analyze(Resume $resume, string $jobDescription): array
    {
        return $this->analyzeText($resume->raw_text, $jobDescription);
    }

    /** @return array<string, mixed> */
    public function analyzeText(string $resumeText, string $jobDescription): array
    {
        if (function_exists('set_time_limit')) {
            @set_time_limit(180);
        }
        @ini_set('max_execution_time', '180');

        $response = (new ResumeAnalysisAgent)->prompt(
            "RESUME:\n{$resumeText}\n\nJOB DESCRIPTION:\n{$jobDescription}",
            [],
            Lab::OpenRouter,
            'openrouter/free',
            120,
        );

        $decoded = json_decode(trim($response->text), true);
        \Log::info($decoded);
        if (! is_array($decoded)) {
            throw new RuntimeException('The AI returned an unreadable analysis. Please try again.');
        }

        return [
            'match_score' => max(0, min(100, (int) Arr::get($decoded, 'match_score', 0))),
            'keywords_matched' => array_values((array) Arr::get($decoded, 'keywords_matched', [])),
            'keywords_missing' => array_values((array) Arr::get($decoded, 'keywords_missing', [])),
            'ats_issues' => array_values((array) Arr::get($decoded, 'ats_issues', [])),
            'interview_questions' => array_values((array) Arr::get($decoded, 'interview_questions', [])),
            // 'cover_letter' => (string) Arr::get($decoded, 'cover_letter', ''),
            'ai_response' => $response->text,
        ];
    }
    
}
