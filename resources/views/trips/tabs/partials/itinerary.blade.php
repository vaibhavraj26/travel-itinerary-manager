{{-- Itinerary Tab --}}
        <div x-show="activeTab === 'itinerary'" x-cloak class="space-y-8">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-page-text">Daily Schedule</h2>
                @if($trip->user_id === Auth::id() || $trip->sharedUsers()->where('user_id', Auth::id())->wherePivot('role', 'editor')->exists())
                    <button @click="showActivityModal = true" class="btn-primary py-2.5 px-5 rounded-xl text-xs font-bold flex items-center gap-2 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        Add Activity
                    </button>
                @endif
            </div>

            @if($itinerary->isEmpty())
                <div class="bg-white rounded-3xl p-16 border border-dashed border-slate-300 text-center flex flex-col items-center justify-center space-y-4">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-300">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <p class="text-slate-500 font-medium">Your itinerary is empty. Start adding activities to map out your journey!</p>
                    @if($trip->user_id === Auth::id() || $trip->sharedUsers()->where('user_id', Auth::id())->wherePivot('role', 'editor')->exists())
                        <button @click="showActivityModal = true" class="btn-primary py-3 px-8 rounded-xl text-sm font-bold cursor-pointer">Add First Activity</button>
                    @endif
                </div>
            @else
                <div class="space-y-6 relative">
                    {{-- Timeline Line --}}
                    <div class="absolute left-6 top-4 bottom-4 w-0.5 bg-slate-100 hidden md:block"></div>

                    @foreach($itinerary as $date => $activities)
                        <div class="relative" x-data="{ dateKey: '{{ $date }}' }">
                            {{-- Day Toggle Button --}}
                            <button @click="openDay = openDay === dateKey ? null : dateKey" 
                                    class="w-full flex items-center justify-between gap-6 mb-4 p-4 rounded-3xl hover:bg-slate-50 transition-all text-left group">
                                <div class="flex items-center gap-6">
                                    <div class="w-12 h-12 rounded-2xl bg-white border-2 border-party-1 flex flex-col items-center justify-center shadow-md z-10 group-hover:scale-105 transition-transform">
                                        <span class="text-[10px] font-black text-party-1 uppercase leading-none">{{ \Carbon\Carbon::parse($date)->format('M') }}</span>
                                        <span class="text-lg font-black text-page-text leading-none">{{ \Carbon\Carbon::parse($date)->format('d') }}</span>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-black text-page-text">{{ \Carbon\Carbon::parse($date)->format('l, F j') }}</h3>
                                        <p class="text-sm text-slate-500 font-medium">{{ $activities->count() }} activities planned</p>
                                    </div>
                                </div>
                                <div class="p-2 rounded-full bg-slate-100 text-slate-400 group-hover:text-party-1 group-hover:bg-party-1/10 transition-all">
                                    <svg class="w-5 h-5 transition-transform duration-300" :class="openDay === dateKey ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </button>

                            {{-- Activities Container --}}
                            <div x-show="openDay === dateKey" x-cloak x-collapse x-transition.duration.300ms class="space-y-4 ml-0 md:ml-16 mb-8">
                                @foreach($activities as $activity)
                                    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-all group relative">
                                        {{-- Hidden form to complete this activity (fallback submit) --}}
                                        <form id="complete-activity-{{ $activity->id }}" action="{{ url('/trips/'.$trip->id.'/activities/'.$activity->id.'/complete') }}" method="POST" class="hidden">
                                            @csrf
                                            @method('PUT')
                                        </form>
                                        <form id="undo-complete-activity-{{ $activity->id }}" action="{{ url('/trips/'.$trip->id.'/activities/'.$activity->id.'/undo-complete') }}" method="POST" class="hidden">
                                            @csrf
                                            @method('PUT')
                                        </form>
                                        <div class="flex flex-col md:flex-row gap-6">
                                            <div class="w-full md:w-32 shrink-0">
                                                <div class="text-sm font-black text-party-1">
                                                    {{ $activity->start_time ? \Carbon\Carbon::parse($activity->start_time)->format('g:i A') : 'All Day' }}
                                                </div>
                                                <div class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-wider">{{ $activity->type }}</div>
                                            </div>
                                            <div class="flex-1 space-y-2">
                                                <h4 class="text-lg font-bold text-page-text group-hover:text-party-1 transition-colors">{{ $activity->title }}</h4>
                                                @if($activity->location)
                                                    <div class="flex items-center gap-1.5 text-slate-500 text-sm font-medium">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                        {{ $activity->location }}
                                                    </div>
                                                @endif
                                                @if($activity->notes)
                                                    <p class="text-slate-600 text-sm leading-relaxed mt-2">{{ $activity->notes }}</p>
                                                @endif
                                            </div>
                                            @if(Auth::user()->id === $trip->user_id || $trip->sharedUsers()->where('user_id', Auth::id())->wherePivot('role', 'editor')->exists())
                                                <div class="flex items-start gap-2">
                                                    <button type="button" @click="editingActivity = {{ $activity->id }}; activityForm.title = '{{ addslashes($activity->title) }}'; activityForm.date = '{{ $activity->date }}'; activityForm.start_time = '{{ $activity->start_time }}'; activityForm.end_time = '{{ $activity->end_time }}'; activityForm.location = '{{ addslashes($activity->location ?? '') }}'; activityForm.notes = '{{ addslashes($activity->notes ?? '') }}'; activityForm.type = '{{ addslashes($activity->type) }}'; activityForm.custom_type = ''; activityForm.is_completed = {{ $activity->is_completed ? 'true' : 'false' }}; activityType = ['activity','transport','accommodation','dining','other'].includes(activityForm.type) ? activityForm.type : 'other'; if (activityType === 'other') { activityForm.custom_type = activityForm.type; } showActivityEditModal = true" class="p-2 hover:bg-blue-50 rounded-lg transition-colors cursor-pointer" title="Edit">
                                                        <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                    </button>
                                                    @if(empty($activity->is_completed))
                                                        <button type="button" @click.prevent.stop="completingActivity = {{ $activity->id }}; showCompleteModal = true" class="p-2 hover:bg-emerald-50 rounded-lg transition-colors cursor-pointer" title="Mark Completed">
                                                            <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                        </button>
                                                    @else
                                                        <button type="button" @click.prevent.stop="document.getElementById('undo-complete-activity-{{ $activity->id }}').submit();" class="px-2 py-1 rounded-lg bg-emerald-50 text-emerald-600 text-xs font-bold hover:bg-emerald-100 transition-colors cursor-pointer" title="Undo completion">Undo</button>
                                                    @endif
                                                    <button type="button" @click="deletingActivity = {{ $activity->id }}; showActivityDeleteModal = true" class="p-2 hover:bg-red-50 rounded-lg transition-colors cursor-pointer" title="Delete">
                                                        <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>