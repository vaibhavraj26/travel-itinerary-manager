{{-- Remove Member Confirmation Modal --}}
    <div x-show="showRemoveMemberModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
         x-cloak>
        <div @click.away="showRemoveMemberModal = false"
             class="bg-white rounded-[2.5rem] w-full max-w-md p-8 shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-red-500 to-red-600"></div>

            <div class="flex justify-center mb-6">
                <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </div>
            </div>

            <h3 class="text-2xl font-bold text-[#071022] text-center mb-2">Remove Member?</h3>
            <p class="text-slate-500 text-center mb-4">Are you sure you want to remove <strong class="text-[#071022]" x-text="removingMemberName"></strong> from this trip? This will revoke their access.</p>

            <div class="flex gap-3">
                <button @click="showRemoveMemberModal = false" class="flex-1 px-4 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition-colors">
                    Cancel
                </button>
                <button type="button" @click.prevent="if (removingMemberId) { document.getElementById('remove-member-form-' + removingMemberId).submit(); }" class="flex-1 px-4 py-3 bg-red-500 hover:bg-red-600 text-white font-bold rounded-xl transition-colors">
                    Remove Member
                </button>
            </div>
        </div>
    </div>