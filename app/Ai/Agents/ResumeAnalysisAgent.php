<?php

namespace App\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Promptable;
use Stringable;

class ResumeAnalysisAgent implements Agent, Conversational, HasTools
{
    use Promptable;

    public function instructions(): Stringable|string
    {
        return <<<'PROMPT'
You are a precise ATS and career-analysis assistant. Compare a resume to a job description
 only using the supplied text. Return valid JSON only, with no Markdown or commentary.
  The object must have: match_score (integer 0-100), keywords_matched (array of concise strings),
   keywords_missing (array of concise strings), ats_issues (array of concise actionable strings),
    interview_questions (array of concise strings),
    //  cover_letter (a tailored professional cover letter).
    //  Do not invent experience, qualifications, employers, or achievements.
PROMPT;
    }

    /** @return Message[] */
    public function messages(): iterable { return []; }

    /** @return Tool[] */
    public function tools(): iterable { return []; }
}
