<header class="sticky top-0 z-10 flex items-center justify-between h-16 px-4 bg-white/80 backdrop-blur-md border-b border-slate-200 sm:px-6 lg:px-8">
    <div class="flex items-center">
        {{-- Mobile Toggle --}}
        <button @click="sidebarOpen = true"
                class="inline-flex items-center justify-center w-9 h-9 rounded-lg border border-slate-200 bg-white text-slate-600 shadow-sm lg:hidden mr-3"
                aria-label="Open sidebar">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
        <div class="hidden lg:block">
            <h2 class="text-lg font-semibold text-slate-800">@yield('header_title', 'Home')</h2>
        </div>
    </div>

    <!-- Right side navbar icons & profile -->
    <div class="flex items-center gap-4">
        <button class="text-slate-400 hover:text-slate-600 transition-colors relative">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            <span class="absolute top-0 right-0 w-2.5 h-2.5 bg-[#FF52A7] border-2 border-white rounded-full"></span>
        </button>

        <!-- Profile Dropdown -->
        <div class="relative" x-data="{ userMenuOpen: false }" @click.outside="userMenuOpen = false">
            <button @click="userMenuOpen = !userMenuOpen" class="flex items-center gap-2 focus:outline-none">
                @if(Auth::user()->avatar)
                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-9 h-9 rounded-full object-cover shadow-md border-2 border-white" alt="{{ Auth::user()->name }}">
                @else
                    <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-[#FF52A7] to-[#7C3AED] flex items-center justify-center text-white font-bold shadow-md border-2 border-white">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                @endif
                <div class="hidden md:block text-left">
                    <p class="text-sm font-semibold text-slate-700 leading-tight">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-slate-500 leading-tight">{{ Auth::user()->plan === 'plus' ? 'Plus Member' : 'Free Member' }}</p>
                </div>
                <svg class="hidden md:block w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>

            <!-- Dropdown menu -->
            <div x-show="userMenuOpen" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-100 py-1 z-50" x-cloak>
                <div class="px-4 py-2 border-b border-slate-50 md:hidden">
                    <p class="text-sm font-semibold text-slate-700">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-slate-500">{{ Auth::user()->email }}</p>
                </div>
                <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">Profile Settings</a>
                <a href="{{ route('pricing') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">Billing</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Sign out</button>
                </form>
            </div>
        </div>
    </div>
</header>
