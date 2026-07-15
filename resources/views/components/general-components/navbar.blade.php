<nav class="sticky top-0 z-50 bg-slate-900/95 backdrop-blur border-b border-slate-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <!-- Logo -->
            <div class="flex items-center gap-3">
                <div
                    class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                    <span class="text-white font-bold text-lg">✨</span>
                </div>
                <h1 class="text-xl font-bold text-white">Resume AI</h1>
            </div>

            <!-- Nav Links -->
            <div class="hidden md:flex items-center gap-8">
                <a href="#" class="text-slate-300 hover:text-white transition text-sm font-medium">Dashboard</a>
                <a href="#" class="text-slate-300 hover:text-white transition text-sm font-medium">Analyze</a>
                <a href="#" class="text-slate-300 hover:text-white transition text-sm font-medium">Recruiter</a>
            </div>

            <!-- User Profile (placeholder) -->
            <div class="flex items-center gap-4">
                @auth
                    <span class="text-slate-300 text-sm">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-slate-400 hover:text-red-400 text-sm">Logout</button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
</nav>