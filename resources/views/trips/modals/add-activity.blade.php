{{-- Add Activity Modal --}}
    <div x-show="showActivityModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
         x-cloak>
        <div class="bg-white rounded-[2rem] w-full max-w-lg overflow-hidden shadow-2xl animate-float-up" @click.away="showActivityModal = false">
            <div class="p-8 space-y-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-2xl font-black text-[#071022]">Add New Activity</h3>
                    <button @click="showActivityModal = false" class="text-slate-400 hover:text-slate-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form action="{{ route('trips.activities.store', $trip) }}" method="POST" class="space-y-4" x-data="{ activityType: 'activity' }">
                    @csrf
                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Title</label>
                        <input type="text" name="title" required class="w-full px-5 py-3 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-[#FF52A7] outline-none transition-all">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Date</label>
                            <input type="date" name="date" required value="{{ $trip->start_date }}" class="w-full px-5 py-3 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-[#FF52A7] outline-none transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Type</label>
                            <div class="relative">
                                <select name="type" x-model="activityType" class="w-full px-5 py-3 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-[#FF52A7] outline-none transition-all appearance-none pr-10">
                                    <option value="activity">Activity</option>
                                    <option value="transport">Transport</option>
                                    <option value="accommodation">Accommodation</option>
                                    <option value="dining">Dining</option>
                                    <option value="other">Other</option>
                                </select>
                                <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div x-show="activityType === 'other'" x-collapse class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Custom Type (Optional)</label>
                        <input type="text" name="custom_type" placeholder="e.g. Shopping" class="w-full px-5 py-3 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-[#FF52A7] outline-none transition-all">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Start Time (Optional)</label>
                            <input type="time" name="start_time" class="w-full px-5 py-3 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-[#FF52A7] outline-none transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-400 uppercase tracking-widest">End Time (Optional)</label>
                            <input type="time" name="end_time" class="w-full px-5 py-3 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-[#FF52A7] outline-none transition-all">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Location</label>
                        <input type="text" name="location" class="w-full px-5 py-3 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-[#FF52A7] outline-none transition-all">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Notes</label>
                        <textarea name="notes" rows="3" class="w-full px-5 py-3 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-[#FF52A7] outline-none transition-all"></textarea>
                    </div>

                    <button type="submit" class="w-full py-4 bg-[#FF52A7] text-white font-black rounded-2xl shadow-lg shadow-[#FF52A7]/30 hover:scale-[1.02] active:scale-[0.98] transition-all mt-4">
                        SAVE ACTIVITY
                    </button>
                </form>
            </div>
        </div>
    </div>