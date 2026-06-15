<header class="sticky top-0 z-40 border-b border-party-1/10 bg-white/80 backdrop-blur-xl">
            <div class="max-w-7xl mx-auto px-6 lg:px-12 h-20 flex items-center justify-between gap-4">
                <a href="{{ route('landing') }}" class="flex items-center gap-3">
                    <x-application-logo />
                    <div class="leading-tight">
                        <div class="font-bold text-lg tracking-tight">triptogether</div>
                        <div class="text-xs text-slate-500 uppercase tracking-[0.25em]">Blog</div>
                    </div>
                </a>

                <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-600">
                    <a href="{{ route('landing') }}" class="hover:text-party-1 transition-colors">Home</a>
                    <a href="{{ route('pricing') }}" class="hover:text-party-1 transition-colors">Pricing</a>
                    <a href="{{ route('blog') }}" class="text-party-1">Blog</a>
                </nav>

                <a href="{{ route('login') }}" class="btn-outline inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-full text-page-text font-semibold text-sm">
                    Sign In
                </a>
            </div>
        </header>