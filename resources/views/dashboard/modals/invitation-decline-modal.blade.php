<div id="invitation-decline-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/40 px-4">
        <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h3 class="text-lg font-bold text-page-text">Decline Invitation</h3>
                    <p class="mt-2 text-sm text-slate-600" id="decline-modal-text">Decline this trip invitation?</p>
                </div>
                <button type="button" class="text-slate-400 hover:text-slate-600" data-modal-close>
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="mt-6 flex items-center justify-end gap-2">
                <button type="button" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:text-slate-800" data-modal-cancel>Cancel</button>
                <form method="POST" id="decline-modal-form" data-action-base="{{ route('trips.members.decline', ['trip' => '__TRIP__']) }}">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg border border-slate-300 text-slate-700 text-sm font-semibold hover:bg-slate-50 transition-colors">
                        Confirm Decline
                    </button>
                </form>
            </div>
        </div>
    </div>