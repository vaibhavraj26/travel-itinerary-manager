{{-- Overview Tab --}}
        <div x-show="activeTab === 'overview'" x-cloak class="space-y-6">
            <div class="bg-amber-50 rounded-3xl p-6 border border-amber-100 shadow-sm flex items-start justify-between gap-4">
                <div>
                    <h3 class="text-sm font-black text-amber-700 uppercase tracking-widest">Quick Notes</h3>
                    <p class="mt-2 text-slate-700 text-sm max-w-3xl">{{ $trip->quick_notes ?? 'No quick notes yet. Use this space to pin short reminders or shared notes for the group.' }}</p>
                </div>
                @if(Auth::id() === $trip->user_id || $trip->sharedUsers()->where('user_id', Auth::id())->wherePivot('role', 'editor')->exists())
                    <div class="flex-shrink-0">
                        <button type="button" @click="showQuickNotesEdit = true" class="px-4 py-2 bg-white border rounded-lg text-sm font-bold hover:bg-slate-50">Edit</button>
                    </div>
                @endif
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm space-y-6">
                        <div>
                            <h2 class="text-xl font-bold text-page-text mb-4">About this trip</h2>
                            <p class="text-slate-600 leading-relaxed">
                                {{ $trip->description ?? 'No description provided for this trip yet. Edit the trip to add more details about your plans, goals, and inspiration for this journey.' }}
                            </p>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                                <p class="text-slate-500 font-semibold">Destination</p>
                                <p class="mt-1 font-bold text-page-text">{{ $trip->destination }}</p>
                            </div>
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                                <p class="text-slate-500 font-semibold">Status</p>
                                <p class="mt-1 font-bold text-page-text">{{ ucfirst($trip->status) }}</p>
                            </div>
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                                <p class="text-slate-500 font-semibold">Dates</p>
                                <p class="mt-1 font-bold text-page-text">
                                    {{ \Carbon\Carbon::parse($trip->start_date)->format('M d') }} – {{ \Carbon\Carbon::parse($trip->end_date)->format('M d, Y') }}
                                </p>
                            </div>
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                                <p class="text-slate-500 font-semibold">Duration</p>
                                <p class="mt-1 font-bold text-page-text">
                                    {{ \Carbon\Carbon::parse($trip->start_date)->diffInDays(\Carbon\Carbon::parse($trip->end_date)) + 1 }} days
                                </p>
                            </div>
                        </div>
                    </div>
                    @php
                        $collaborators = $trip->sharedUsers->where('pivot.is_accepted', true);
                        $nextActivity = $trip->activities->first(function ($activity) {
                            return empty($activity->is_completed);
                        });
                    @endphp
                    <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm space-y-6">
                        <div>
                            <h3 class="text-lg font-bold text-page-text">People & Next Activity</h3>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                                <p class="text-slate-500 font-semibold">Trip Owner</p>
                                <p class="mt-1 font-bold text-page-text">{{ $trip->user->name }}</p>
                            </div>
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                                <p class="text-slate-500 font-semibold">Collaborators</p>
                                <p class="mt-1 font-bold text-page-text">
                                    {{ $collaborators->isEmpty() ? 'None yet' : $collaborators->pluck('name')->join(', ') }}
                                </p>
                            </div>
                            <div class="sm:col-span-2 p-4 rounded-2xl bg-slate-50 border border-slate-100">
                                <p class="text-slate-500 font-semibold">Top Pending Activity</p>
                                @if($nextActivity)
                                    <div class="flex items-center justify-between gap-3">
                                        <div>
                                            <p class="mt-1 font-bold text-page-text">{{ $nextActivity->title }}</p>
                                            <p class="text-xs text-slate-500 mt-1">
                                                {{ \Carbon\Carbon::parse($nextActivity->date)->format('M d, Y') }}
                                                @if($nextActivity->start_time)
                                                    • {{ \Carbon\Carbon::parse($nextActivity->start_time)->format('g:i A') }}
                                                @endif
                                                @if($nextActivity->location)
                                                    • {{ $nextActivity->location }}
                                                @endif
                                            </p>
                                        </div>
                                        @if(Auth::user()->id === $trip->user_id || $trip->sharedUsers()->where('user_id', Auth::id())->wherePivot('role', 'editor')->exists())
                                            <div>
                                                @if(empty($nextActivity->is_completed))
                                                    <button type="button" @click="completingActivity = {{ $nextActivity->id }}; showCompleteModal = true" class="px-3 py-2 bg-emerald-50 text-emerald-700 rounded-lg text-sm font-bold cursor-pointer">Mark Completed</button>
                                                @else
                                                    <button type="button" @click.prevent="document.getElementById('undo-complete-activity-{{ $nextActivity->id }}').submit();" class="px-3 py-2 bg-emerald-50 text-emerald-700 rounded-lg text-sm font-bold hover:bg-emerald-100 transition-colors cursor-pointer">Undo</button>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <p class="mt-1 font-bold text-page-text">No upcoming activities</p>
                                    <p class="text-xs text-slate-500 mt-1">Add activities to see what is next.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @php
                    $startDate = \Carbon\Carbon::parse($trip->start_date)->startOfDay();
                    $endDate = \Carbon\Carbon::parse($trip->end_date)->startOfDay();
                    $todayDate = \Carbon\Carbon::today();
                    $totalTripDays = $startDate->diffInDays($endDate) + 1;

                    if ($trip->status === 'cancelled') {
                        $tripStatusSummary = 'Cancelled';
                        $tripStatusMeta = 'This trip has been cancelled.';
                    } elseif ($todayDate->lt($startDate)) {
                        $daysUntilStart = $todayDate->diffInDays($startDate);
                        $tripStatusSummary = $daysUntilStart . ' day' . ($daysUntilStart === 1 ? '' : 's') . ' left';
                        $tripStatusMeta = 'Starts on ' . $startDate->format('M d, Y');
                    } elseif ($todayDate->greaterThan($endDate)) {
                        $tripStatusSummary = 'Trip completed';
                        $tripStatusMeta = 'Ended on ' . $endDate->format('M d, Y');
                    } else {
                        $activeDayNumber = $startDate->diffInDays($todayDate) + 1;
                        $tripStatusSummary = 'Day ' . $activeDayNumber . ' of ' . $totalTripDays;
                        $tripStatusMeta = 'Trip is currently active';
                    }

                    $budgetTotal = (float) ($trip->budget ?? 0);
                    $budgetUsedPercent = $budgetTotal > 0 ? round(($totalSpent / $budgetTotal) * 100, 1) : 0;
                    $budgetBarPercent = max(0, min(100, $budgetUsedPercent));
                    $isBudgetWarning = $budgetTotal > 0 && $budgetUsedPercent >= 80;
                    $isBudgetOver = $budgetTotal > 0 && $totalSpent > $budgetTotal;

                    $totalActivities = $trip->activities->count();
                    $completedActivities = $trip->activities->filter(function ($activity) {
                        return !empty($activity->is_completed);
                    })->count();
                    $completionPercent = $totalActivities > 0 ? (int) round(($completedActivities / $totalActivities) * 100) : 0;
                @endphp
                <div class="space-y-6">
                    <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm space-y-4">
                        <h2 class="text-lg font-bold text-page-text">Trip Countdown & Status</h2>
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                            <p class="text-slate-500 font-semibold text-sm">Current Status</p>
                            <p class="mt-1 font-black text-page-text text-lg">{{ $tripStatusSummary }}</p>
                            <p class="text-xs text-slate-500 mt-1">{{ $tripStatusMeta }}</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm space-y-4">
                        <h2 class="text-lg font-bold text-page-text">Budget Health</h2>
                        <div class="grid grid-cols-3 gap-3 text-center">
                            <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100">
                                <p class="text-[11px] text-slate-500 font-semibold">Budget</p>
                                <p class="mt-1 text-sm font-black text-page-text">₹{{ number_format($budgetTotal, 2) }}</p>
                            </div>
                            <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100">
                                <p class="text-[11px] text-slate-500 font-semibold">Spent</p>
                                <p class="mt-1 text-sm font-black text-page-text">₹{{ number_format($totalSpent, 2) }}</p>
                            </div>
                            <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100">
                                <p class="text-[11px] text-slate-500 font-semibold">Remaining</p>
                                <p class="mt-1 text-sm font-black {{ $remaining < 0 ? 'text-red-500' : 'text-emerald-600' }}">₹{{ number_format($remaining, 2) }}</p>
                            </div>
                        </div>
                        <div>
                            <div class="h-2 rounded-full bg-slate-100 overflow-hidden">
                                <div class="h-full {{ $isBudgetOver ? 'bg-red-500' : ($isBudgetWarning ? 'bg-amber-500' : 'bg-emerald-500') }}" style="width: {{ $budgetBarPercent }}%;"></div>
                            </div>
                            <p class="text-xs text-slate-500 mt-2">{{ number_format($budgetUsedPercent, 1) }}% of budget used</p>
                            @if($isBudgetWarning)
                                <p class="text-xs font-semibold mt-1 {{ $isBudgetOver ? 'text-red-600' : 'text-amber-600' }}">
                                    {{ $isBudgetOver ? 'Warning: Budget exceeded.' : 'Warning: You have crossed 80% of your budget.' }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm space-y-4">
                        <h2 class="text-lg font-bold text-page-text">Completion Progress</h2>
                        <div class="flex items-end justify-between">
                            <p class="text-sm text-slate-500">Activities done</p>
                            <p class="text-sm font-black text-page-text">{{ $completedActivities }} / {{ $totalActivities }}</p>
                        </div>
                        <div class="h-2 rounded-full bg-slate-100 overflow-hidden">
                            <div class="h-full bg-party-1" style="width: {{ $completionPercent }}%;"></div>
                        </div>
                        <p class="text-xs text-slate-500">{{ $completionPercent }}% completed</p>
                    </div>

                </div>
            </div>
        </div>