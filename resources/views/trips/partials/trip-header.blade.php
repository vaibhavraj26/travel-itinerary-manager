{{-- Trip Header Section --}}
    <div class="relative h-80 rounded-[2.5rem] overflow-hidden shadow-2xl group">
        <img src="{{ $trip->image_url ?? 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?q=80&w=2021&auto=format&fit=crop' }}" 
             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" alt="{{ $trip->title }}">
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
        
        <div class="absolute bottom-8 left-8 right-8 flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div class="space-y-2">
                <div class="flex items-center gap-3">
                    <span class="px-3 py-1 bg-[#FF52A7] rounded-full text-[10px] font-black text-white uppercase tracking-widest">
                        {{ $trip->status }}
                    </span>
                    <div class="flex items-center gap-1 text-white/80 text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ $trip->destination }}
                    </div>
                </div>
                <h1 class="text-4xl md:text-5xl font-black text-white font-['Playfair_Display',serif] tracking-tight">
                    {{ $trip->title }}
                </h1>
                <p class="text-white/60 text-sm md:text-base font-medium max-w-2xl">
                    {{ \Carbon\Carbon::parse($trip->start_date)->format('M d') }} — {{ \Carbon\Carbon::parse($trip->end_date)->format('M d, Y') }} ({{ \Carbon\Carbon::parse($trip->start_date)->diffInDays(\Carbon\Carbon::parse($trip->end_date)) + 1 }} days)
                </p>
            </div>
            
            <div class="flex items-center gap-4 flex-none min-w-max">
                <div class="flex -space-x-3 shrink-0">
                    @foreach($trip->sharedUsers as $member)
                        @if($member->pivot->is_accepted)
                            @if($member->avatar)
                                <img src="{{ asset('storage/' . $member->avatar) }}" class="w-10 h-10 rounded-full border-2 border-white object-cover shadow-lg" title="{{ $member->name }}">
                            @else
                                <div class="w-10 h-10 rounded-full border-2 border-white shadow-lg bg-slate-100 text-slate-600 flex items-center justify-center text-sm font-black uppercase" title="{{ $member->name }}">
                                    {{ strtoupper(substr($member->name, 0, 1)) }}
                                </div>
                            @endif
                        @else
                            @if($member->avatar)
                                <img src="{{ asset('storage/' . $member->avatar) }}" class="w-10 h-10 rounded-full border-2 border-amber-300 object-cover opacity-60 shadow-md" title="{{ $member->name }} (Pending Invitation)">
                            @else
                                <div class="w-10 h-10 rounded-full border-2 border-amber-300 bg-slate-100 text-slate-600 flex items-center justify-center text-sm font-black uppercase opacity-80 shadow-md" title="{{ $member->name }} (Pending Invitation)">
                                    {{ strtoupper(substr($member->name, 0, 1)) }}
                                </div>
                            @endif
                        @endif
                    @endforeach
                    @foreach($trip->invitations as $invitation)
                        <div class="w-10 h-10 rounded-full border-2 border-dashed border-amber-300 bg-white/20 backdrop-blur-sm flex items-center justify-center text-amber-200 opacity-70 shadow-md" title="{{ $invitation->email }} (Pending Registration)">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                    @endforeach
                    @if($trip->user_id === Auth::id())
                        <button type="button" @click="showInviteModal = true" class="w-10 h-10 flex-none rounded-full bg-white/20 backdrop-blur-md border-2 border-white/30 flex items-center justify-center text-white hover:bg-white/40 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        </button>
                    @endif
                </div>
                @if($trip->user_id === Auth::id())
                    <a href="{{ route('trips.edit', $trip) }}" class="w-10 h-10 flex-none rounded-full bg-white/20 backdrop-blur-md border-2 border-white/30 flex items-center justify-center text-white hover:bg-white/40 transition-colors shadow-lg">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    </a>
                    <form action="{{ route('trips.destroy', $trip) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this trip? This action cannot be undone.');" class="inline-block flex-none">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-10 h-10 flex-none rounded-full bg-white/20 backdrop-blur-md border-2 border-white/30 flex items-center justify-center text-white hover:bg-red-500/80 transition-colors shadow-lg">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>