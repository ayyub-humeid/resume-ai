<?php

namespace App\Services;

use App\Ai\Agents\CoverLetterGeneratorAgent;
use App\Models\Analysis;
use Illuminate\Support\Arr;
use Laravel\Ai\Enums\Lab;
use RuntimeException;

class CoverLetterGeneratorService
{
    public function generate(Analysis $analysis): string
    {
        $resume = $analysis->resume;
        $job = $analysis->job;

        $response = (new CoverLetterGeneratorAgent)->prompt(
            "RESUME:\n{$resume->raw_text}\n\nJOB TITLE: {$job->title}\nCOMPANY: {$job->company}\nJOB DESCRIPTION:\n{$job->description}",
            [],
            Lab::OpenRouter,
            'openrouter/free',
            60,
        );

        $decoded = json_decode(trim($response->text), true);

        if (! is_array($decoded) || empty($decoded['cover_letter'])) {
            throw new RuntimeException('The AI returned an unreadable cover letter. Please try again.');
        }

        return (string) Arr::get($decoded, 'cover_letter');
    }
}