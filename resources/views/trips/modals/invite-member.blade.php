{{-- Invite Member Modal --}}
    <div x-show="showInviteModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
         x-cloak>
        <div class="bg-white rounded-[2rem] w-full max-w-md overflow-hidden shadow-2xl animate-float-up" @click.away="showInviteModal = false">
            <div class="p-8 space-y-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-2xl font-black text-[#071022]">Invite Buddy</h3>
                    <button @click="showInviteModal = false" class="text-slate-400 hover:text-slate-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form action="{{ route('trips.members.store', $trip) }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Email Address</label>
                        <input type="email" name="email" required placeholder="friend@example.com" class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-[#FF52A7] outline-none transition-all">
                        <p class="text-[10px] text-slate-400 font-medium">If they don't have an account, they'll receive an invitation to register & join!</p>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Role</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="role" value="viewer" checked class="peer sr-only">
                                <div class="p-4 border-2 border-slate-100 rounded-xl peer-checked:border-[#FF52A7] peer-checked:bg-[#FF52A7]/5 transition-all text-center">
                                    <span class="block font-bold text-slate-700">Viewer</span>
                                    <span class="block text-[10px] text-slate-400">Can only view</span>
                                </div>
                            </label>
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="role" value="editor" class="peer sr-only">
                                <div class="p-4 border-2 border-slate-100 rounded-xl peer-checked:border-[#FF52A7] peer-checked:bg-[#FF52A7]/5 transition-all text-center">
                                    <span class="block font-bold text-slate-700">Editor</span>
                                    <span class="block text-[10px] text-slate-400">Can edit itinerary</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-4 bg-[#071022] text-white font-black rounded-2xl shadow-xl hover:bg-slate-800 transition-all">
                        SEND INVITATION
                    </button>
                </form>
            </div>
        </div>
    </div>