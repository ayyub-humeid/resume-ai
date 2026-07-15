<x-layouts.dashboard-layout :title="$pageTitle" :heading="$pageHeading ?? 'Resumes'"
    description="{{ $pageDescription ?? 'Upload, view, and manage your resumes. You can also analyze them against job descriptions to see how well they match.' }}">
    <livewire:resume.resume-upload />
</x-layouts.dashboard-layout>
