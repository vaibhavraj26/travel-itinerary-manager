{{-- Invitation Response Banner --}}
    @php
        $myPivot = $trip->sharedUsers->where('id', Auth::id())->first()->pivot ?? null;
    @endphp
    @if($myPivot && !$myPivot->is_accepted)
        <div class="bg-gradient-to-r from-amber-500 to-orange-600 rounded-[2.5rem] p-8 text-white shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-white border border-white/20">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <div>
                    <h3 class="font-black text-lg">You've been invited!</h3>
                    <p class="text-white/80 text-sm">Join this itinerary as an <strong>{{ strtoupper($myPivot->role) }}</strong> to start planning together.</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <form action="{{ route('trips.members.accept', $trip) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-6 py-2.5 bg-white text-orange-600 rounded-xl text-sm font-black hover:scale-105 transition-all shadow-md cursor-pointer">
                        Accept & Join
                    </button>
                </form>
                <form action="{{ route('trips.members.decline', $trip) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-6 py-2.5 bg-transparent border border-white/40 text-white rounded-xl text-sm font-bold hover:bg-white/10 hover:border-white/60 transition-all cursor-pointer">
                        Decline
                    </button>
                </form>
            </div>
        </div>
    @endif