{{-- Settlements Tab --}}
    <div x-show="activeTab === 'settlements'" x-cloak class="space-y-8">
        @if(Auth::user()->plan === 'plus')
            <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm">
                <div class="flex items-start justify-between gap-4 mb-5">
                    <div>
                        <p class="text-slate-500 text-xs font-bold uppercase tracking-widest">Bill Split</p>
                        <h3 class="text-xl font-black mt-1">Auto Settlement</h3>
                    </div>
                    <div class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-bold">
                        {{ $settlementParticipants->count() }} people
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-6 text-sm">
                    <div class="rounded-2xl bg-slate-50 p-4">
                        <p class="text-slate-500 text-xs uppercase tracking-widest">Shared Spend</p>
                        <p class="text-lg font-black mt-1">₹{{ number_format($sharedExpenses->sum('amount'), 2) }}</p>
                    </div>
                    <div class="rounded-2xl bg-slate-50 p-4">
                        <p class="text-slate-500 text-xs uppercase tracking-widest">Per Person</p>
                        <p class="text-lg font-black mt-1">₹{{ number_format($sharePerPerson, 2) }}</p>
                    </div>
                    <div class="rounded-2xl bg-slate-50 p-4">
                        <p class="text-slate-500 text-xs uppercase tracking-widest">Status</p>
                        <p class="text-lg font-black mt-1">{{ $settlementTransfers->isEmpty() ? 'Settled' : 'Needs Settlement' }}</p>
                    </div>
                </div>

                <div class="space-y-4 mb-6">
                    @foreach($settlementBalances as $balance)
                        <div class="flex items-center justify-between gap-3 rounded-2xl bg-slate-50 p-4">
                            <div>
                                <p class="font-bold">{{ $balance['user']->name }}</p>
                                <p class="text-xs text-slate-500 mt-1">Paid ₹{{ number_format($balance['paid'], 2) }} • Share ₹{{ number_format($balance['share'], 2) }}</p>
                            </div>
                            <div class="text-right">
                                @if($balance['balance'] > 0)
                                    <p class="font-black text-emerald-500">Gets back ₹{{ number_format($balance['balance'], 2) }}</p>
                                @elseif($balance['balance'] < 0)
                                    <p class="font-black text-rose-500">Owes ₹{{ number_format(abs($balance['balance']), 2) }}</p>
                                @else
                                    <p class="font-black text-slate-600">Settled</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-widest">Who Pays Whom</p>
                    <h3 class="text-xl font-black text-page-text mt-1 mb-5">Suggested Transfers</h3>

                    <div class="space-y-3">
                        @if($settlementTransfers->isEmpty())
                            <div class="rounded-2xl bg-emerald-50 border border-emerald-100 p-5 text-center">
                                <p class="font-bold text-emerald-700">All bills are settled.</p>
                                <p class="text-sm text-emerald-600 mt-1">No one owes anyone anything right now.</p>
                            </div>
                        @else
                            @foreach($settlementTransfers as $transfer)
                                <div class="rounded-2xl bg-slate-50 border border-slate-100 p-4 flex items-center justify-between gap-4">
                                    <div>
                                        <p class="font-bold text-page-text">{{ $transfer['from']->name }}</p>
                                        <p class="text-xs text-slate-500 mt-1">should pay</p>
                                    </div>
                                    <div class="px-3 py-1 rounded-full bg-party-1/10 text-party-1 text-sm font-black">
                                        ₹{{ number_format($transfer['amount'], 2) }}
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-page-text">to  {{ $transfer['to']->name }}</p>
                                        <p class="text-xs text-slate-500 mt-1">to settle the trip</p>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="bg-gradient-to-br from-page-text to-[#1a2942] rounded-3xl p-10 md:p-16 text-center flex flex-col items-center justify-center space-y-8 relative overflow-hidden shadow-2xl">
                <div class="w-24 h-24 bg-white/10 backdrop-blur-md rounded-full flex items-center justify-center text-yellow-400 border border-white/20 relative z-10 shadow-[0_0_40px_rgba(250,204,21,0.2)]">
                    <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                </div>
                <div class="relative z-10 space-y-3">
                    <h2 class="text-3xl font-black text-white font-['Playfair_Display',serif] tracking-tight">Settlements are a Plus feature</h2>
                    <p class="text-white/70 max-w-lg mx-auto text-sm md:text-base leading-relaxed">Upgrade to <strong class="text-white">Explorer Plus</strong> to automatically split bills, view suggested transfers, and mark settlements as paid.</p>
                </div>

                <a href="{{ route('pricing') }}" class="relative z-10 btn-primary py-3.5 px-8 rounded-xl text-page-text font-black shadow-[0_0_20px_rgba(255,82,167,0.4)] hover:scale-105 hover:shadow-[0_0_30px_rgba(255,82,167,0.6)] transition-all duration-300 flex items-center gap-2">
                    View Premium Plans
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        @endif
    </div>