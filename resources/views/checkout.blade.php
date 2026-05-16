@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-transparent page-root pt-4 pb-24">
    <div class="max-w-4xl mx-auto px-6 lg:px-12">
        
        <div class="mb-10 text-center">
            <h2 class="font-['Playfair_Display',serif] text-4xl font-black text-[#071022]">
                Complete your <span class="text-[#FF52A7]">Upgrade</span>
            </h2>
            <p class="mt-3 text-slate-600 text-base">
                You're almost there! Choose how you'd like to start your Explorer Plus subscription.
            </p>
        </div>

        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-200 overflow-hidden flex flex-col md:flex-row">
            
            {{-- Left Side: Order Summary --}}
            <div class="w-full md:w-5/12 bg-gradient-to-br from-[#FFF7F0] to-[#fae593]/10 p-8 border-b md:border-b-0 md:border-r border-slate-200">
                <div class="mb-8">
                    <div class="text-[#FF52A7] text-xs font-bold tracking-widest uppercase mb-2">Selected Plan</div>
                    <div class="font-['Playfair_Display',serif] text-3xl font-black text-[#071022] mb-1">Explorer Plus</div>
                    <div class="flex items-baseline gap-1">
                        <span class="text-2xl font-bold text-[#071022]">$9</span>
                        <span class="text-slate-500 text-sm">/month</span>
                    </div>
                </div>

                <div class="space-y-4 mb-8">
                    <h4 class="text-sm font-bold text-slate-800">What's included:</h4>
                    @foreach(['Unlimited Trips','AI-Powered Suggestions','Real-Time Collaboration','Budget & Expense Tracker','Offline Mode','Priority Support'] as $feature)
                    <div class="flex items-center gap-3 text-slate-700 text-sm font-medium">
                        <span class="w-4 h-4 rounded-full bg-emerald-500/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-2.5 h-2.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </span>
                        {{ $feature }}
                    </div>
                    @endforeach
                </div>

                <div class="pt-6 border-t border-slate-200/60">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-slate-600 text-sm">Subtotal</span>
                        <span class="text-slate-800 font-semibold">$9.00</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-600 text-sm">Tax</span>
                        <span class="text-slate-800 font-semibold">$0.00</span>
                    </div>
                    <div class="flex justify-between items-center mt-4 pt-4 border-t border-slate-200/60">
                        <span class="text-slate-800 font-bold">Total Due Today</span>
                        <span class="text-xl font-bold text-[#071022]">$9.00</span>
                    </div>
                </div>
            </div>

            {{-- Right Side: Payment Details --}}
            <div class="w-full md:w-7/12 p-8">
                <form action="{{ route('checkout.submit') }}" method="POST">
                    @csrf
                    
                    {{-- Trial vs Direct Toggle --}}
                    <div class="mb-8 p-1 bg-slate-100 rounded-xl flex">
                        <label class="flex-1 text-center py-3 rounded-lg cursor-pointer hover:bg-white/50 text-slate-500 hover:text-slate-700 transition-all">
                            <input type="radio" name="payment_type" value="trial" class="hidden">
                            <span class="block text-sm font-semibold">Start 14-Day Free Trial</span>
                        </label>
                        <label class="flex-1 text-center py-3 rounded-lg cursor-pointer bg-white shadow-sm border border-slate-200 transition-all">
                            <input type="radio" name="payment_type" value="direct" class="hidden" checked>
                            <span class="block text-sm font-bold text-[#071022]">Pay Directly Now</span>
                        </label>
                    </div>

                    <div id="payment-fields" class="space-y-5 transition-all duration-300">
                        <h4 class="text-sm font-bold text-slate-800 border-b border-slate-100 pb-2">Payment Details</h4>
                        
                        <div id="trial-notice" class="bg-emerald-50 border border-emerald-200 rounded-xl px-4 py-3 text-emerald-700 text-sm font-medium flex items-center gap-2 hidden">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            No payment details needed for your free trial. You can add them later.
                        </div>

                        <div id="card-fields">
                            <div class="mb-5">
                                <label for="cardholder_name" class="block text-xs font-semibold text-slate-700 mb-1">Cardholder Name</label>
                                <input type="text" id="cardholder_name" name="cardholder_name" class="checkout-input w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#FF52A7]/30 focus:border-[#FF52A7] outline-none text-slate-800 placeholder-slate-400" placeholder="John Doe">
                                <p class="text-red-500 text-xs mt-1 hidden" id="err-name">Please enter the cardholder name.</p>
                            </div>

                            <div class="mb-5">
                                <label for="card_number" class="block text-xs font-semibold text-slate-700 mb-1">Card Number</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                    </div>
                                    <input type="text" id="card_number" name="card_number" maxlength="19" class="checkout-input w-full pl-11 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#FF52A7]/30 focus:border-[#FF52A7] outline-none text-slate-800 placeholder-slate-400 font-mono tracking-widest" placeholder="0000 0000 0000 0000">
                                </div>
                                <p class="text-red-500 text-xs mt-1 hidden" id="err-card">Please enter a valid 16-digit card number.</p>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="expiry_date" class="block text-xs font-semibold text-slate-700 mb-1">Expiry Date</label>
                                    <input type="text" id="expiry_date" name="expiry_date" maxlength="5" class="checkout-input w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#FF52A7]/30 focus:border-[#FF52A7] outline-none text-slate-800 placeholder-slate-400 text-center" placeholder="MM/YY">
                                    <p class="text-red-500 text-xs mt-1 hidden" id="err-expiry">Enter a valid expiry (MM/YY).</p>
                                </div>
                                <div>
                                    <label for="cvc" class="block text-xs font-semibold text-slate-700 mb-1">CVC</label>
                                    <input type="text" id="cvc" name="cvc" maxlength="4" class="checkout-input w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#FF52A7]/30 focus:border-[#FF52A7] outline-none text-slate-800 placeholder-slate-400 text-center" placeholder="123">
                                    <p class="text-red-500 text-xs mt-1 hidden" id="err-cvc">Enter a valid 3 or 4-digit CVC.</p>
                                </div>
                            </div>
                        </div>

                        <div class="pt-4">
                            <p id="terms-text" class="text-xs text-slate-500 mb-4 leading-relaxed">
                                By proceeding, you agree to our Terms of Service. Your card will be charged $9.00 immediately for the first month.
                            </p>
                            <button type="submit" id="checkout-btn" class="w-full btn-primary py-3.5 rounded-xl text-[#071022] font-bold text-sm shadow-lg shadow-[#FF52A7]/20 hover:-translate-y-0.5 transition-transform">
                                Pay $9.00 Now
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const paymentFields = document.getElementById('payment-fields');
    const trialNotice = document.getElementById('trial-notice');
    const cardFields = document.getElementById('card-fields');
    const checkoutBtn = document.getElementById('checkout-btn');
    const totalText = document.querySelector('.text-xl.font-bold');
    const termsText = document.getElementById('terms-text');
    const allInputs = document.querySelectorAll('.checkout-input');

    // Card number auto-formatting (add spaces every 4 digits)
    document.getElementById('card_number').addEventListener('input', (e) => {
        let val = e.target.value.replace(/\D/g, '').substring(0, 16);
        e.target.value = val.replace(/(\d{4})(?=\d)/g, '$1 ');
    });

    // Expiry auto-formatting (add slash after MM)
    document.getElementById('expiry_date').addEventListener('input', (e) => {
        let val = e.target.value.replace(/\D/g, '').substring(0, 4);
        if (val.length >= 2) val = val.substring(0, 2) + '/' + val.substring(2);
        e.target.value = val;
    });

    // CVC: digits only
    document.getElementById('cvc').addEventListener('input', (e) => {
        e.target.value = e.target.value.replace(/\D/g, '').substring(0, 4);
    });

    function setTrialMode() {
        trialNotice.classList.remove('hidden');
        cardFields.classList.add('hidden');
        allInputs.forEach(i => { i.disabled = true; i.value = ''; });
        // Hide all errors
        document.querySelectorAll('[id^="err-"]').forEach(e => e.classList.add('hidden'));
        checkoutBtn.innerText = 'Start 14-Day Free Trial';
        totalText.innerText = '$0.00*';
        termsText.innerText = 'By starting your trial, you agree to our Terms of Service. You will not be charged until your 14-day trial ends. Cancel anytime before then.';
    }

    function setDirectMode() {
        trialNotice.classList.add('hidden');
        cardFields.classList.remove('hidden');
        allInputs.forEach(i => i.disabled = false);
        checkoutBtn.innerText = 'Pay $9.00 Now';
        totalText.innerText = '$9.00';
        termsText.innerText = 'By proceeding, you agree to our Terms of Service. Your card will be charged $9.00 immediately for the first month.';
    }

    // Toggle handler
    document.querySelectorAll('input[name="payment_type"]').forEach(radio => {
        radio.addEventListener('change', (e) => {
            const labels = document.querySelectorAll('label.cursor-pointer');
            
            // Reset styles
            labels.forEach(l => {
                l.classList.remove('bg-white', 'shadow-sm', 'border-slate-200');
                l.classList.add('hover:bg-white/50', 'text-slate-500', 'border-transparent');
                l.querySelector('span').classList.replace('font-bold', 'font-semibold');
                l.querySelector('span').classList.remove('text-[#071022]');
            });

            // Apply active styles to selected
            const activeLabel = e.target.parentElement;
            activeLabel.classList.remove('hover:bg-white/50', 'text-slate-500', 'border-transparent');
            activeLabel.classList.add('bg-white', 'shadow-sm', 'border-slate-200');
            activeLabel.querySelector('span').classList.replace('font-semibold', 'font-bold');
            activeLabel.querySelector('span').classList.add('text-[#071022]');

            if (e.target.value === 'trial') {
                setTrialMode();
            } else {
                setDirectMode();
            }
        });
    });

    // Form validation on submit
    document.querySelector('form').addEventListener('submit', (e) => {
        const isTrial = document.querySelector('input[name="payment_type"]:checked').value === 'trial';
        if (isTrial) return; // No validation needed for trial

        let isValid = true;

        // Name validation
        const name = document.getElementById('cardholder_name');
        const errName = document.getElementById('err-name');
        if (!name.value.trim()) {
            errName.classList.remove('hidden');
            name.classList.add('border-red-500');
            isValid = false;
        } else {
            errName.classList.add('hidden');
            name.classList.remove('border-red-500');
        }

        // Card number validation (16 digits)
        const card = document.getElementById('card_number');
        const errCard = document.getElementById('err-card');
        const cardDigits = card.value.replace(/\D/g, '');
        if (cardDigits.length !== 16) {
            errCard.classList.remove('hidden');
            card.classList.add('border-red-500');
            isValid = false;
        } else {
            errCard.classList.add('hidden');
            card.classList.remove('border-red-500');
        }

        // Expiry validation (MM/YY)
        const expiry = document.getElementById('expiry_date');
        const errExpiry = document.getElementById('err-expiry');
        const expiryMatch = expiry.value.match(/^(0[1-9]|1[0-2])\/\d{2}$/);
        if (!expiryMatch) {
            errExpiry.classList.remove('hidden');
            expiry.classList.add('border-red-500');
            isValid = false;
        } else {
            errExpiry.classList.add('hidden');
            expiry.classList.remove('border-red-500');
        }

        // CVC validation (3-4 digits)
        const cvc = document.getElementById('cvc');
        const errCvc = document.getElementById('err-cvc');
        const cvcDigits = cvc.value.replace(/\D/g, '');
        if (cvcDigits.length < 3 || cvcDigits.length > 4) {
            errCvc.classList.remove('hidden');
            cvc.classList.add('border-red-500');
            isValid = false;
        } else {
            errCvc.classList.add('hidden');
            cvc.classList.remove('border-red-500');
        }

        if (!isValid) {
            e.preventDefault();
        }
    });

    // Clear error on input focus
    document.querySelectorAll('.checkout-input').forEach(input => {
        input.addEventListener('focus', () => {
            input.classList.remove('border-red-500');
            const errEl = input.closest('div').querySelector('[id^="err-"]') || input.parentElement.querySelector('[id^="err-"]');
            if (errEl) errEl.classList.add('hidden');
        });
    });
</script>
@endsection
