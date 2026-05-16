<aside 
    :class="sidebarOpen ? 'w-64 translate-x-0' : 'w-20 -translate-x-full lg:translate-x-0'"
    class="fixed inset-y-0 left-0 z-50 bg-white border-r border-slate-200 transition-all duration-300 lg:sticky lg:top-0 lg:inset-0 lg:flex lg:flex-col lg:h-screen lg:shrink-0 relative">
    
    {{-- Toggle Button - "In between line" --}}
    <button @click="sidebarOpen = !sidebarOpen"
            class="hidden lg:flex absolute -right-4 top-12 items-center justify-center w-8 h-8 rounded-full border border-slate-200 bg-white text-slate-600 shadow-sm hover:bg-slate-50 hover:text-slate-900 transition-colors focus:outline-none z-50"
            aria-label="Toggle sidebar">
        <svg x-show="!sidebarOpen" x-cloak class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <svg x-show="sidebarOpen" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
    </button>

    {{-- Sidebar Header --}}
    <div class="flex items-center h-16 px-5 border-b border-slate-100 bg-white shrink-0 overflow-hidden">
        <a href="{{ route('home') }}" class="flex items-center gap-4 shrink-0">
            {{-- Brand icon --}}
            <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-xl bg-[#FF52A7]/5">
                <svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-7 h-7">
                    <path d="M16 5C12.134 5 9 8.134 9 12c0 6.125 7 15 7 15s7-8.875 7-15c0-3.866-3.134-7-7-7z" fill="#FF52A7"/>
                    <circle cx="16" cy="12" r="3" fill="white"/>
                </svg>
            </div>
            {{-- Brand text - hidden when collapsed --}}
            <span x-show="sidebarOpen" x-transition.opacity.duration.300ms class="font-['Playfair_Display',serif] font-black text-xl text-[#071022] whitespace-nowrap">
                trip<span class="text-[#FF52A7]">together</span>
            </span>
        </a>
    </div>

    {{-- Navigation --}}
    <nav :class="sidebarOpen ? 'overflow-y-auto' : 'overflow-visible'" 
         class="flex-1 px-3 py-4 space-y-1"
         x-data="{ activeItem: '{{ request()->routeIs('home') ? 'Home' : (request()->routeIs('trips.*') ? 'My Trips' : (request()->routeIs('profile.*') ? 'Profile' : '')) }}' }">
        @php
            $navItems = [
                ['name' => 'Home', 'route' => 'home', 'icon' => '<path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>'],
                ['name' => 'My Trips', 'route' => 'trips.index', 'icon' => '<path d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
                ['name' => 'Itineraries', 'route' => '#', 'icon' => '<path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>'],
                ['name' => 'Budget', 'route' => '#', 'icon' => '<path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
                ['name' => 'Calendar', 'route' => '#', 'icon' => '<path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>'],
                ['name' => 'Profile', 'route' => 'profile.show', 'icon' => '<path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>'],
                ['name' => 'Settings', 'route' => '#', 'icon' => '<path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>'],
            ];
        @endphp

        @foreach($navItems as $item)
            <a href="{{ $item['route'] !== '#' ? route($item['route']) : '#' }}" 
               @click="activeItem = '{{ $item['name'] }}'"
               :class="activeItem === '{{ $item['name'] }}' ? 'bg-[#FF52A7]/10 text-[#FF52A7]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
               class="flex items-center gap-4 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 group relative">
                <div class="shrink-0 w-6 h-6 flex items-center justify-center">
                    <svg class="w-5.5 h-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        {!! $item['icon'] !!}
                    </svg>
                </div>
                {{-- Text Label --}}
                <span x-show="sidebarOpen" x-transition.opacity.duration.300ms class="whitespace-nowrap overflow-hidden font-semibold">
                    {{ $item['name'] }}
                </span>

                {{-- Custom Tooltip (shown only when sidebar is closed) --}}
                <div x-show="!sidebarOpen" 
                     class="absolute left-full ml-1 px-3 py-2 bg-slate-900 text-white text-[11px] font-bold rounded-lg opacity-0 group-hover:opacity-100 transition-all duration-200 pointer-events-none whitespace-nowrap z-[100] shadow-xl translate-x-2 group-hover:translate-x-0 hidden lg:block">
                    {{ $item['name'] }}
                    {{-- Tooltip Arrow --}}
                    <div class="absolute right-full top-1/2 -translate-y-1/2 border-6 border-transparent border-r-slate-900"></div>
                </div>
            </a>
        @endforeach
    </nav>

    {{-- Sidebar Footer (Plan Info) --}}
    <div class="p-3 border-t border-slate-100 overflow-hidden shrink-0">
        @if(Auth::user()->plan === 'plus')
            <div class="bg-gradient-to-br from-[#FFF2E6] to-[#FFF7F0] border border-[#FFB800]/30 rounded-xl p-3 transition-all duration-300 min-h-[52px] flex items-center">
                <div class="flex items-center gap-4 w-full">
                    <div class="w-8 h-8 rounded-lg bg-[#FFB800]/10 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-[#C9A84C]" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <div x-show="sidebarOpen" x-transition.opacity.duration.300ms class="flex flex-col overflow-hidden">
                        <span class="text-xs font-bold text-[#C9A84C] uppercase tracking-wider whitespace-nowrap">Plus</span>
                        <p class="text-[10px] text-slate-500 leading-tight">Premium Active</p>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-3 transition-all duration-300 min-h-[52px] flex flex-col justify-center">
                <div class="flex items-center gap-4">
                    <div class="w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center shrink-0">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                    </div>
                    <span x-show="sidebarOpen" x-transition.opacity.duration.300ms class="text-xs font-bold text-emerald-700 uppercase tracking-wider whitespace-nowrap">Free Plan</span>
                </div>
                <a x-show="sidebarOpen" x-transition.opacity.duration.300ms href="{{ route('pricing') }}" class="block w-full mt-2.5 py-2 bg-white rounded-lg text-center text-xs font-bold text-emerald-700 border border-emerald-200 hover:bg-emerald-100 transition-colors whitespace-nowrap">
                    Upgrade
                </a>
            </div>
        @endif
    </div>
</aside>
