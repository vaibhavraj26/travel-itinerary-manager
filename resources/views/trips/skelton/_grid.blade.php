@php
    // This partial expects $trips and $hasAnyTrips to be defined
@endphp

@if(!isset($hasAnyTrips) || !$hasAnyTrips)
    <div class="bg-white rounded-3xl p-12 border border-dashed border-slate-300 text-center flex flex-col items-center justify-center space-y-6">
        <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center text-slate-300">
            <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <h2 class="text-xl font-bold text-[#071022]">No trips planned yet</h2>
            <p class="text-slate-500 mt-2 max-w-sm mx-auto">Start your journey by creating your first travel itinerary. It only takes a few minutes!</p>
        </div>
        <a href="{{ route('trips.create') }}" class="btn-primary py-3 px-8 rounded-xl text-[#071022] font-bold shadow-lg shadow-[#FF52A7]/20 hover:scale-105 transition-transform">
            Get Started
        </a>
    </div>
@elseif($trips->isEmpty())
    <div class="bg-white rounded-3xl p-12 border border-dashed border-slate-300 text-center flex flex-col items-center justify-center space-y-6">
        <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center text-slate-300">
            <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-2.21 0-4 1.79-4 4v1h8v-1c0-2.21-1.79-4-4-4zM6 12v6a2 2 0 002 2h8a2 2 0 002-2v-6"/></svg>
        </div>
        <div>
            <h2 class="text-xl font-bold text-[#071022]">No trips found</h2>
            <p class="text-slate-500 mt-2 max-w-sm mx-auto">We couldn't find any trips matching your search or filters.
            Try different keywords or <a href="{{ route('trips.index') }}" class="text-[#FF52A7] font-bold">clear filters</a> to see all trips.</p>
        </div>
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($trips as $trip)
            <a href="{{ route('trips.show', $trip) }}" class="group bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col h-full focus:outline-none focus:ring-2 focus:ring-[#FF52A7] focus:ring-offset-2">
                {{-- Card Image --}}
                <div class="relative h-48 overflow-hidden">
                    <img src="{{ $trip->image_url ?? 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?q=80&w=2021&auto=format&fit=crop' }}" 
                         alt="{{ $trip->destination }}" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-4 left-4">
                        <span class="px-2 py-1 bg-white/20 backdrop-blur-md rounded-lg text-[10px] font-bold text-white uppercase tracking-wider border border-white/30">
                            {{ $trip->status }}
                        </span>
                        <h3 class="text-white font-bold text-xl mt-1">{{ $trip->title }}</h3>
                    </div>
                </div>

                {{-- Card Body --}}
                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div class="space-y-3">
                        <div class="flex items-center gap-2 text-slate-500 text-sm">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span class="font-medium text-slate-700">{{ $trip->destination }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-slate-500 text-sm">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>{{ \Carbon\Carbon::parse($trip->start_date)->format('M d') }} - {{ \Carbon\Carbon::parse($trip->end_date)->format('M d, Y') }}</span>
                        </div>
                        <p class="text-slate-600 text-sm line-clamp-2 mt-2">
                            {{ $trip->description ?? 'No description added yet for this adventure.' }}
                        </p>
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-50 flex items-center justify-between">
                        @php
                            // 1. Gather all active / accepted members
                            $members = collect([$trip->user])->merge($trip->sharedUsers->toBase()->where('pivot.is_accepted', true));
                            
                            // 2. Gather all pending invites (registered + unregistered guests)
                            $pendingShared = $trip->sharedUsers->toBase()->where('pivot.is_accepted', false)->map(function($u) {
                                return (object)['name' => $u->name, 'id' => $u->id, 'avatar' => $u->avatar ?? null, 'is_pending' => true, 'is_guest' => false];
                            });
                            $pendingGuests = $trip->invitations->toBase()->map(function($inv) {
                                $prefix = explode('@', $inv->email)[0];
                                return (object)['name' => $prefix, 'id' => $inv->id, 'avatar' => null, 'is_pending' => true, 'is_guest' => true];
                            });
                            $pending = $pendingShared->merge($pendingGuests);

                            $allAvatars = $members->map(function($m) {
                                return (object)['name' => $m->name, 'id' => $m->id, 'avatar' => $m->avatar ?? null, 'is_pending' => false, 'is_guest' => false];
                            })->merge($pending);

                            $totalCount = $allAvatars->count();
                            $displayAvatars = $allAvatars->take(3);
                            $remainingCount = $totalCount - 3;
                        @endphp

                        <div class="flex -space-x-2">
                            @foreach($displayAvatars as $avatar)
                                @if($avatar->is_guest)
                                    <div class="w-8 h-8 rounded-full bg-slate-100 border-2 border-white flex items-center justify-center text-[10px] font-bold text-slate-500 shadow-sm uppercase" title="{{ $avatar->name }} (Pending Registration)">
                                        {{ substr($avatar->name, 0, 1) }}
                                    </div>
                                @else
                                    @if(!empty($avatar->avatar))
                                        <img src="{{ asset('storage/' . $avatar->avatar) }}" 
                                             class="w-8 h-8 rounded-full border-2 object-cover {{ $avatar->is_pending ? 'border-amber-400 opacity-60' : 'border-white' }} shadow-sm" 
                                             alt="{{ $avatar->name }}"
                                             title="{{ $avatar->name }}{{ $avatar->is_pending ? ' (Pending)' : '' }}">
                                    @else
                                        <div class="w-8 h-8 rounded-full border-2 {{ $avatar->is_pending ? 'border-amber-400 opacity-60' : 'border-white' }} bg-slate-100 text-slate-600 shadow-sm flex items-center justify-center text-[10px] font-black uppercase" 
                                             title="{{ $avatar->name }}{{ $avatar->is_pending ? ' (Pending)' : '' }}">
                                            {{ strtoupper(substr($avatar->name, 0, 1)) }}
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                            
                            @if($remainingCount > 0)
                                <div class="w-8 h-8 rounded-full bg-slate-100 border-2 border-white flex items-center justify-center text-[10px] font-bold text-slate-500 shadow-sm">+{{ $remainingCount }}</div>
                            @endif
                        </div>
                        <div class="text-sm font-bold text-[#FF52A7] group-hover:underline flex items-center gap-1">
                            Details
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
@endif
