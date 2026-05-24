{{-- Quick Notes Edit Modal --}}
    <div x-show="showQuickNotesEdit" x-cloak class="fixed inset-0 z-[110] flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm">
        <div class="bg-white rounded-[2rem] w-full max-w-md overflow-hidden shadow-2xl" @click.away="showQuickNotesEdit = false">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-black text-[#071022]">Edit Quick Notes</h3>
                    <button @click="showQuickNotesEdit = false" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('trips.quicknotes.update', $trip) }}">
                    @csrf
                    @method('PUT')
                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Quick Notes</label>
                        <textarea name="quick_notes" rows="4" class="w-full px-4 py-3 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-[#FF52A7] outline-none transition-all">{{ old('quick_notes', $trip->quick_notes) }}</textarea>
                    </div>

                    <div class="mt-4 flex gap-3 justify-end">
                        <button type="button" @click="showQuickNotesEdit = false" class="px-4 py-2 rounded-lg border">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-[#FF52A7] text-white rounded-lg font-bold">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>