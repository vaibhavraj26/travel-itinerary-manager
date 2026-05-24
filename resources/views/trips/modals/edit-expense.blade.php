{{-- Edit Expense Modal --}}
    <div x-show="showEditModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
         x-cloak>
        <div @click.away="showEditModal = false" 
             class="bg-white rounded-[2.5rem] w-full max-w-md p-8 shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-500 to-blue-600"></div>
            
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-[#071022]">Edit Transaction</h3>
                <button @click="showEditModal = false" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form x-show="editingExpense" :action="`/trips/{{ $trip->id }}/expenses/${editingExpense}`" method="POST" class="space-y-4" x-data="{ expenseCategory: editForm.category ?? 'food', isbudget: editForm.type === 'budget' }" x-effect="isbudget = editForm.type === 'budget'; expenseCategory = editForm.category ?? 'food'" @change="isbudget = editForm.type === 'budget'">
                @csrf
                @method('PUT')
                
                <div x-show="!isbudget" class="space-y-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Title</label>
                    <input type="text" name="title" x-model="editForm.title" :disabled="isbudget" required class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-blue-500 outline-none transition-all disabled:opacity-50 disabled:bg-slate-100">
                </div>

                <div class="grid gap-4" :class="{ 'grid-cols-1': isbudget, 'grid-cols-2': !isbudget }">
                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Amount (₹)</label>
                        <input type="number" step="0.01" name="amount" x-model.number="editForm.amount" required class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-blue-500 outline-none transition-all">
                    </div>
                    <div x-show="!isbudget" class="space-y-2">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Category</label>
                        <div class="relative">
                            <select name="category" x-model="expenseCategory" :disabled="isbudget" class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-blue-500 outline-none transition-all appearance-none pr-10 disabled:opacity-50 disabled:bg-slate-100">
                                <option value="food">Food & Dining</option>
                                <option value="transport">Transportation</option>
                                <option value="accommodation">Accommodation</option>
                                <option value="activities">Activities</option>
                                <option value="other">Other</option>
                            </select>
                            <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div x-show="!isbudget && expenseCategory === 'other'" x-collapse class="space-y-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Custom Category</label>
                    <input type="text" name="custom_category" placeholder="e.g. Souvenirs" class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-blue-500 outline-none transition-all">
                </div>

                <template x-if="isbudget">
                    <input type="hidden" name="category" :value="expenseCategory">
                </template>
                <template x-if="isbudget">
                    <input type="hidden" name="title" :value="editForm.title">
                </template>

                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest">Paid By</label>
                    <div class="relative">
                        <select name="paid_by" x-model="editForm.paid_by" class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent rounded-xl focus:bg-white focus:border-blue-500 outline-none transition-all appearance-none pr-10">
                            <option value="">Select who paid...</option>
                            <option value="{{ $trip->user_id }}">{{ $trip->user->name }} (Owner)</option>
                            @foreach($trip->sharedUsers as $member)
                                @if($member->pivot->is_accepted)
                                    <option value="{{ $member->id }}">{{ $member->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full btn-primary py-4 rounded-xl text-[#071022] font-black text-sm shadow-xl shadow-blue-500/20 hover:-translate-y-1 transition-transform">
                    Save Changes
                </button>
            </form>
        </div>
    </div>