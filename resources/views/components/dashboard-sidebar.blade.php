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
            <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-xl bg-party-1/5">
                <x-application-logo />
            </div>
            {{-- Brand text - hidden when collapsed --}}
            <span x-show="sidebarOpen" x-transition.opacity.duration.300ms class="font-['Playfair_Display',serif] font-black text-xl text-page-text whitespace-nowrap">
                trip<span class="text-party-1">together</span>
            </span>
        </a>
    </div>

    {{-- Navigation --}}
    <nav :class="sidebarOpen ? 'overflow-y-auto' : 'overflow-visible'" 
         class="flex-1 px-3 py-4 space-y-1"
         x-data="{ activeItem: '{{ request()->routeIs('home') ? 'Home' : (request()->routeIs('ai.planner') ? 'AI Planner' : (request()->routeIs('trips.*') ? 'My Trips' : (request()->routeIs('profile.*') ? 'Profile' : ''))) }}' }">
        @php
            $navItems = [
                ['name' => 'Home', 'route' => 'home', 'icon' => '<path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>'],
                ['name' => 'My Trips', 'route' => 'trips.index', 'icon' => '<path d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
                ['name' => 'AI Planner', 'route' => 'ai.planner', 'icon' => '<path d="M14 12.6483L16.3708 10.2775C16.6636 9.98469 16.81 9.83827 16.8883 9.68032C17.0372 9.3798 17.0372 9.02696 16.8883 8.72644C16.81 8.56849 16.6636 8.42207 16.3708 8.12923C16.0779 7.83638 15.9315 7.68996 15.7736 7.61169C15.473 7.46277 15.1202 7.46277 14.8197 7.61169C14.6617 7.68996 14.5153 7.83638 14.2225 8.12923L11.8517 10.5M14 12.6483L5.77754 20.8708C5.4847 21.1636 5.33827 21.31 5.18032 21.3883C4.8798 21.5372 4.52696 21.5372 4.22644 21.3883C4.06849 21.31 3.92207 21.1636 3.62923 20.8708C3.33639 20.5779 3.18996 20.4315 3.11169 20.2736C2.96277 19.973 2.96277 19.6202 3.11169 19.3197C3.18996 19.1617 3.33639 19.0153 3.62923 18.7225L11.8517 10.5M14 12.6483L11.8517 10.5" stroke-linecap="round"/><path d="M19.5 2.5L19.3895 2.79873C19.2445 3.19044 19.172 3.38629 19.0292 3.52917C18.8863 3.67204 18.6904 3.74452 18.2987 3.88946L18 4L18.2987 4.11054C18.6904 4.25548 18.8863 4.32796 19.0292 4.47083C19.172 4.61371 19.2445 4.80956 19.3895 5.20127L19.5 5.5L19.6105 5.20127C19.7555 4.80956 19.828 4.61371 19.9708 4.47083C20.1137 4.32796 20.3096 4.25548 20.7013 4.11054L21 4L20.7013 3.88946C20.3096 3.74452 20.1137 3.67204 19.9708 3.52917C19.828 3.38629 19.7555 3.19044 19.6105 2.79873L19.5 2.5Z"/><path d="M19.5 12.5L19.3895 12.7987C19.2445 13.1904 19.172 13.3863 19.0292 13.5292C18.8863 13.672 18.6904 13.7445 18.2987 13.8895L18 14L18.2987 14.1105C18.6904 14.2555 18.8863 14.328 19.0292 14.4708C19.172 14.6137 19.2445 14.8096 19.3895 15.2013L19.5 15.5L19.6105 15.2013C19.7555 14.8096 19.828 14.6137 19.9708 14.4708C20.1137 14.328 20.3096 14.2555 20.7013 14.1105L21 14L20.7013 13.8895C20.3096 13.7445 20.1137 13.672 19.9708 13.5292C19.828 13.3863 19.7555 13.1904 19.6105 12.7987L19.5 12.5Z"/><path d="M10.5 2.5L10.3895 2.79873C10.2445 3.19044 10.172 3.38629 10.0292 3.52917C9.88629 3.67204 9.69044 3.74452 9.29873 3.88946L9 4L9.29873 4.11054C9.69044 4.25548 9.88629 4.32796 10.0292 4.47083C10.172 4.61371 10.2445 4.80956 10.3895 5.20127L10.5 5.5L10.6105 5.20127C10.7555 4.80956 10.828 4.61371 10.9708 4.47083C11.1137 4.32796 11.3096 4.25548 11.7013 4.11054L12 4L11.7013 3.88946C11.3096 3.74452 11.1137 3.67204 10.9708 3.52917C10.828 3.38629 10.7555 3.19044 10.6105 2.79873L10.5 2.5Z"/>'],
                ['name' => 'Profile', 'route' => 'profile.show', 'icon' => '<path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>'],
            ];
        @endphp

        @foreach($navItems as $item)
            <a href="{{ $item['route'] !== '#' ? route($item['route']) : '#' }}" 
               @click="activeItem = '{{ $item['name'] }}'"
               :class="activeItem === '{{ $item['name'] }}' ? 'bg-party-1/10 text-party-1' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
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
                @if($item['name'] === 'AI Planner' && Auth::user()->plan !== 'plus')
                    <span x-show="sidebarOpen" x-transition.opacity.duration.300ms class="ml-auto text-[9px] font-black uppercase tracking-widest px-2 py-1 rounded-full bg-amber-100 text-amber-700">
                        Upgrade
                    </span>
                @endif

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
            <div class="bg-gradient-to-br from-[#FFF2E6] to-gold-base border border-[#FFB800]/30 rounded-xl p-3 transition-all duration-300 min-h-[52px] flex items-center">
                <div class="flex items-center gap-4 w-full">
                    <div class="w-8 h-8 rounded-lg bg-[#FFB800]/10 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-gold" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <div x-show="sidebarOpen" x-transition.opacity.duration.300ms class="flex flex-col overflow-hidden">
                        <span class="text-xs font-bold text-gold uppercase tracking-wider whitespace-nowrap">Plus</span>
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
