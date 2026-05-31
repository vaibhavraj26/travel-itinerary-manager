{{-- Delete Activity Confirmation Modal --}}
    <div x-show="showActivityDeleteModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
         x-cloak>
        <div @click.away="showActivityDeleteModal = false" class="bg-white rounded-[2rem] w-full max-w-sm p-8 shadow-2xl">
            <h3 class="text-xl font-black text-page-text mb-2">Delete activity?</h3>
            <p class="text-slate-500 text-sm mb-6">This action cannot be undone.</p>
            <div class="flex gap-3">
                <button @click="showActivityDeleteModal = false" class="flex-1 px-4 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition-colors">
                    Cancel
                </button>
                <form x-show="deletingActivity" :action="`/trips/{{ $trip->id }}/activities/${deletingActivity}`" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-3 bg-red-500 hover:bg-red-600 text-white font-bold rounded-xl transition-colors">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>