<div class="w-full">
    <!-- Upload Card -->
    <!-- Success Message -->
    @if ($message && str_contains($message, '✓'))
        <div class="p-4 bg-green-500/15 border border-green-500/40 rounded-lg m-2">
            <p class="text-green-400 font-medium text-sm">{{ $message }}</p>
        </div>
    @endif

    <!-- Error Message -->
    @if ($message && str_contains($message, '✗'))
        <div class="p-4 bg-red-500/15 border border-red-500/40 rounded-lg m-2">
            <p class="text-red-400 font-medium text-sm">{{ $message }}</p>
        </div>
    @endif
    @if ($page == 'index')
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-xl border border-slate-700 p-8 shadow-lg">

            <!-- Section Title -->

            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold text-white">Upload Resume</h3>
                    <p class="text-slate-400 mt-2">PDF, DOC, or DOCX format (Max 5MB)</p>
                </div>
                <!-- Section Title -->

                <button wire:click="changePage" class="bg-blue-600 p-3 rounded-xl cursor-pointer ">New Upload
                    resume</button>

            </div>
        </div>
    @endif




    <!-- Resumes List Section -->
    @if ($page == 'index')

        @if (count($resumes) > 0)
            <div class="mt-12">
                <h3 class="text-2xl font-bold text-white mb-6">Your Resumes</h3>
                <div class="grid gap-4">
                    @foreach ($resumes as $resume)
                        <div
                            class="bg-slate-800/50 border border-slate-700 rounded-lg p-5 hover:border-slate-600 transition flex items-center justify-between group">
                            <div class="flex-1">
                                <!-- File Icon + Info -->
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center">
                                        <svg class="h-6 w-6 text-blue-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-white">{{ $resume->title }}</h4>
                                        <p class="text-slate-400 text-sm">{{ $resume->file_name }}</p>
                                        <p class="text-slate-500 text-xs mt-1">Added
                                            {{ $resume->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition">
                                {{-- <img src="{{ asset('storage/' . $user->image) }}" alt="User"> --}}
                                <a href="{{ asset('storage/' . $resume->file_path) }}" type="button"
                                    class="px-3 py-1 bg-slate-700 hover:bg-slate-600 text-white text-sm rounded font-medium transition">
                                    View
                                </a>
                                <button type="button" wire:click="delete({{ $resume->id }})"
                                    wire:confirm="Delete this resume?"
                                    class="px-3 py-1 bg-red-500/20 hover:bg-red-500/30 text-red-400 text-sm rounded font-medium transition">
                                    Delete
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="mt-12 text-center py-12 bg-slate-800/30 rounded-xl border border-slate-700 border-dashed">
                <svg class="h-16 w-16 text-slate-500 mx-auto mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="text-slate-400">No resumes uploaded yet</p>
            </div>
        @endif
    @else
        <!-- Form -->
        <form wire:submit="submitResume" class="space-y-6 mt-2">

            <!-- File Upload with Drag & Drop -->
            <div class="relative">
                <div class="border-2 border-dashed border-slate-600 rounded-xl p-12 text-center transition hover:border-blue-500 hover:bg-blue-500/5 cursor-pointer"
                    @dragover.prevent="$el.classList.add('border-blue-500', 'bg-blue-500/5')"
                    @dragleave.prevent="$el.classList.remove('border-blue-500', 'bg-blue-500/5')"
                    @drop.prevent="$el.classList.remove('border-blue-500', 'bg-blue-500/5'); @this.set('resume_file', $event.dataTransfer.files[0])">

                    <input type="file" wire:model="resume_file" accept=".pdf,.doc,.docx" class="hidden"
                        id="fileInput">

                    <label for="fileInput" class="cursor-pointer block">
                        <!-- Upload Icon -->
                        <svg class="mx-auto h-16 w-16 mb-4 text-slate-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8m0 8l-4-2m4 2l4-2" />
                        </svg>

                        <p class="text-lg font-semibold text-white">Drop your resume here</p>
                        <p class="text-slate-400 text-sm mt-1">or click to browse files</p>
                    </label>
                </div>

                <!-- File Preview -->
                @if ($resume_file)
                    <div class="mt-4 p-4 bg-green-500/10 border border-green-500/30 rounded-lg flex items-center gap-3">
                        <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <div>
                            <p class="text-green-400 font-medium text-sm">{{ $resume_file->getClientOriginalName() }}
                            </p>
                            <p class="text-green-300/70 text-xs">{{ round($resume_file->getSize() / 1024, 2) }} KB</p>
                        </div>
                    </div>
                @endif

                <!-- Validation Errors -->
                @error('resume_file')
                    <x-general-components.validation-input-error-message :message="$message" />
                @enderror
            </div>

            <!-- Resume Title Input -->
            <div>
                <label for="title" class="block text-sm font-medium text-white mb-2">
                    Resume Title (Optional)
                </label>
                <input type="text" id="title" wire:model="title"
                    placeholder="e.g., Senior Backend Developer - 2024"
                    class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600 rounded-lg text-white placeholder-slate-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
            </div>

            <!-- Submit Button -->
            <div class="flex gap-3">
                <button type="submit" wire:loading.attr="disabled"
                    class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 disabled:from-slate-500 disabled:to-slate-600 text-white font-semibold py-3 px-4 rounded-lg transition transform hover:scale-105 disabled:scale-100">

                    <span wire:loading.remove class="flex items-center justify-center gap-2">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Upload Resume
                    </span>

                    <span wire:loading class="flex items-center justify-center gap-2">
                        <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <circle cx="12" cy="12" r="10" stroke-width="2" opacity="0.25" />
                            <path d="M12 2a10 10 0 010 20" stroke-width="2" />
                        </svg>
                        Uploading...
                    </span>
                </button>
            </div>


        </form>
    @endif
</div>
