<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('analyses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('resume_id')->constrained('resumes')->onDelete('cascade');
            $table->foreignId('job_id')->constrained('job_listings')->onDelete('cascade');
            $table->integer('match_score')->default(0); // 0-100
            $table->json('keywords_matched')->nullable();
            $table->json('keywords_missing')->nullable();
            $table->json('ats_issues')->nullable();
            $table->json('interview_questions')->nullable();
            $table->longText('cover_letter')->nullable();
            $table->longText('ai_response')->nullable(); // raw AI API response
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analyses');
    }
};
