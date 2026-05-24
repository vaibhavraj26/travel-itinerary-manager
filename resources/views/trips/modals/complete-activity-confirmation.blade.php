{{-- Complete Activity Confirmation Modal --}}
    <div x-show="showCompleteModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
         x-cloak>
        <div @click.away="showCompleteModal = false" class="bg-white rounded-[2rem] w-full max-w-sm p-8 shadow-2xl">
            <h3 class="text-xl font-black text-[#071022] mb-2">Mark activity as completed?</h3>
            <p class="text-slate-500 text-sm mb-6">Are you sure you want to mark this activity as completed? You can undo this from the activity editor.</p>
            <div class="flex gap-3">
                <button type="button" @click="showCompleteModal = false" class="flex-1 px-4 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition-colors cursor-pointer">
                    Cancel
                </button>
                <button type="button" @click.prevent.stop="document.getElementById('complete-activity-' + completingActivity).submit();" class="flex-1 w-full px-4 py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-xl transition-colors cursor-pointer">
                    Confirm
                </button>
            </div>
        </div>
    </div>