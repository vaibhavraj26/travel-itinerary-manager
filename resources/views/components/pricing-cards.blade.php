@props([
    'freeLabel' => 'Get Started Free',
    'freeUrl' => '#',
    'plusLabel' => 'Start 14-Day Free Trial',
    'plusUrl' => '#',
    'animated' => false,
    'freeCurrent' => false,
    'plusCurrent' => false,
]) 

<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    {{-- Free --}}
    <div class="{{ $animated ? 'reveal feature-card' : '' }} bg-[#FFF7F0] border border-[#EDE1D8] rounded-3xl p-10 relative">
        <div class="absolute top-10 right-10 border border-[#C9A84C]/30 text-[#C9A84C] text-xs font-bold px-3 py-1 rounded-full">FREE</div>
        <div class="text-slate-400 text-sm font-semibold tracking-widest uppercase mb-3">Explorer</div>
        <div class="font-['Playfair_Display',serif] text-5xl font-black text-[#071022] mb-1">Free</div>
        <div class="text-slate-500 text-sm mb-8">Perfect to get started</div>
        <ul class="space-y-3 mb-10">
            @foreach(['3 Active Trips','Basic Itinerary Builder','PDF Export','Community Support'] as $feature)
            <li class="flex items-center gap-3 text-slate-700 text-sm">
                <span class="w-5 h-5 rounded-full bg-emerald-500/20 flex items-center justify-center flex-shrink-0">
                    <svg class="w-3 h-3 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </span>
                {{ $feature }}
            </li>
            @endforeach
            @foreach(['AI-Powered Suggestions', 'Offline Mode'] as $feature)
            <li class="flex items-center gap-3 text-slate-400 text-sm line-through opacity-70">
                <span class="w-5 h-5 rounded-full border border-slate-300/40 bg-slate-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-3 h-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </span>
                {{ $feature }}
            </li>
            @endforeach
        </ul>
        @if($freeCurrent)
            <div class="w-full block text-center py-3.5 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 font-semibold text-sm flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                {{ $freeLabel }}
            </div>
        @elseif($plusCurrent)
            <div class="btn-outline no-lift w-full block text-center py-3.5 rounded-full text-[#C9A84C] font-semibold text-sm">
                {{ $freeLabel }} 
            </div>
        @else
            <a href="{{ $freeUrl }}" class="btn-outline w-full block text-center py-3.5 rounded-full text-[#C9A84C] font-semibold text-sm">{{ $freeLabel }}</a>
        @endif
    </div>

    {{-- Pro --}}
    <div class="{{ $animated ? 'reveal feature-card' : '' }} relative bg-gradient-to-br from-[#FFF2E6] to-[#FFF7F0] border border-[#FFB800]/30 rounded-3xl p-10 overflow-hidden">
        <div class="absolute top-10 right-10 bg-[#C9A84C] text-[#070B14] text-xs font-bold px-3 py-1 rounded-full">POPULAR</div>
        <div class="text-[#C9A84C] text-sm font-semibold tracking-widest uppercase mb-3">Explorer Plus</div>
        <div class="flex items-end gap-1 mb-1">
            <span class="font-['Playfair_Display',serif] text-5xl font-black text-[#071022]">$9</span>
            <span class="text-slate-400 text-sm mb-2">/month</span>
        </div>
        <div class="text-slate-500 text-sm mb-8">For serious travellers</div>
        <ul class="space-y-3 mb-10">
            @foreach(['Unlimited Trips','AI-Powered Suggestions','Real-Time Collaboration','Budget & Expense Tracker','Offline Mode','Priority Support'] as $feature)
            <li class="flex items-center gap-3 text-slate-700 text-sm">
                <span class="w-5 h-5 rounded-full bg-[#C9A84C]/20 flex items-center justify-center flex-shrink-0">
                    <svg class="w-3 h-3 text-[#C9A84C]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </span>
                {{ $feature }}
            </li>
            @endforeach
        </ul>
        @if($plusCurrent)
            <div class="w-full block text-center py-3.5 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 font-bold text-sm flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                {{ $plusLabel }}
            </div>
        @else
            <a href="{{ $plusUrl }}" class="btn-primary w-full block text-center py-3.5 rounded-full text-[#070B14] font-bold text-sm">{{ $plusLabel }}</a>
        @endif
    </div>
</div>
