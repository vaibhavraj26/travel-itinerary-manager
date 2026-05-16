<footer class="bg-[#040811] text-white py-10 border-t border-slate-800 font-['Sora',sans-serif] relative z-10 mt-auto">
    <div class="max-w-7xl mx-auto px-6 lg:px-12">
        @if(request()->routeIs('landing'))
        <!-- CTA Section in Footer -->
        <div class="flex flex-col md:flex-row justify-between items-center bg-gradient-to-r from-[#1A2540] to-[#071022] rounded-2xl p-6 lg:p-8 mb-10 border border-[#FFB800]/20 relative overflow-hidden shadow-2xl shadow-black/50">
             <div class="absolute inset-0 bg-[url('radial-gradient(circle_at_top_right,rgba(255,82,167,0.15),transparent_60%)')] pointer-events-none"></div>
             <div class="relative z-10 text-center md:text-left mb-6 md:mb-0 max-w-xl">
                 <h3 class="font-['Playfair_Display',serif] text-2xl lg:text-3xl font-bold text-white mb-2">Ready to pack your bags?</h3>
                 <p class="text-slate-400 text-sm lg:text-base">Join thousands of travelers planning smarter today. Create your first itinerary in seconds.</p>
             </div>
             <div class="relative z-10 flex-shrink-0">
                 <a href="{{ route('register', ['plan' => 'free']) }}" class="btn-primary inline-flex items-center gap-2 px-6 py-3 rounded-full text-[#071022] font-bold text-sm btn-glow transition-transform">
                    Get Started Free
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                 </a>
             </div>
        </div>
        @endif

        <!-- Main Footer Content -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8 mb-10">
            <!-- Brand & App Links -->
            <div class="lg:col-span-2">
                <div class="flex items-center gap-2 mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-8 h-8 text-[#FF52A7]" fill="none" stroke="currentColor" stroke-width="1.5">
                      <path d="M12 2C8.134 2 5 5.134 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.866-3.134-7-7-7z" fill="#FF52A7" stroke="none"/>
                      <circle cx="12" cy="9" r="2.5" fill="#FFF" />
                    </svg>
                    <span class="font-bold text-2xl tracking-tight text-white">triptogether</span>
                </div>
                <p class="text-slate-400 text-sm leading-relaxed mb-8 max-w-sm">
                    The ultimate travel itinerary planner. Organize flights, hotels, and activities all in one place, and collaborate with your friends effortlessly.
                </p>
                <!-- App Store Buttons -->
                <div class="flex flex-wrap gap-4">
                    <a href="#" class="flex items-center gap-3 bg-white/5 border border-white/10 hover:border-white/30 hover:bg-white/10 transition-all px-5 py-2.5 rounded-xl group">
                        <svg class="w-7 h-7 text-white group-hover:scale-110 transition-transform" viewBox="0 0 384 512" fill="currentColor">
                            <path d="M318.7 268.7c-.2-36.7 16.4-64.4 50-84.8-18.8-26.9-47.2-41.7-84.7-44.6-35.5-2.8-74.3 20.7-88.5 20.7-15 0-49.4-19.7-76.4-19.7C63.3 141.2 4 184.8 4 273.5q0 39.3 14.4 81.2c12.8 36.7 59 126.7 107.2 125.2 25.2-.6 43-17.9 75.8-17.9 31.8 0 48.3 17.9 76.4 17.9 48.6-.7 90.4-82.5 102.6-119.3-65.2-30.7-61.7-90-61.7-91.9zm-56.6-164.2c27.3-32.4 24.8-61.9 24-72.5-24.1 1.4-52 16.4-67.9 34.9-17.5 19.8-27.8 44.3-25.6 71.9 26.1 2 49.9-11.4 69.5-34.3z"/>
                        </svg>
                        <div class="text-left">
                            <div class="text-[10px] text-slate-300 uppercase leading-none">Download on the</div>
                            <div class="text-base font-semibold leading-tight text-white">App Store</div>
                        </div>
                    </a>
                    <a href="#" class="flex items-center gap-3 bg-white/5 border border-white/10 hover:border-white/30 hover:bg-white/10 transition-all px-5 py-2.5 rounded-xl group">
                        <svg class="w-7 h-7 group-hover:scale-110 transition-transform text-[#3DDC84]" viewBox="0 0 512 512" fill="currentColor">
                            <path d="M325.3 234.3L104.6 13l280.8 161.2-60.1 60.1zM47 0C34 6.8 25.3 19.2 25.3 35.3v441.3c0 16.1 8.7 28.5 21.7 35.3l256.6-256L47 0zm425.2 225.6l-58.9-34.1-65.7 64.5 65.7 64.5 60.1-34.1c18-14.3 18-46.5-1.2-60.8zM104.6 499l280.8-161.2-60.1-60.1L104.6 499z" fill="#fff"/>
                        </svg>
                        <div class="text-left">
                            <div class="text-[10px] text-slate-300 uppercase leading-none">GET IT ON</div>
                            <div class="text-base font-semibold leading-tight text-white">Google Play</div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Links -->
            <div>
                <h4 class="text-white font-semibold text-lg mb-5">Product</h4>
                <ul class="space-y-3">
                    <li><a href="#features" class="text-slate-400 hover:text-[#FFD166] transition-colors text-sm">Features</a></li>
                    <li><a href="#pricing" class="text-slate-400 hover:text-[#FFD166] transition-colors text-sm">Pricing</a></li>
                    <li><a href="#destinations" class="text-slate-400 hover:text-[#FFD166] transition-colors text-sm">Destinations</a></li>
                    <li><a href="#" class="text-slate-400 hover:text-[#FFD166] transition-colors text-sm">Integration</a></li>
                    <li><a href="#" class="text-slate-400 hover:text-[#FFD166] transition-colors text-sm">Changelog <span class="ml-2 inline-block bg-[#7C3AED]/20 text-[#7C3AED] text-[10px] font-bold px-2 py-0.5 rounded-full">NEW</span></a></li>
                </ul>
            </div>
            
            <div>
                <h4 class="text-white font-semibold text-lg mb-5">Company</h4>
                <ul class="space-y-3">
                    <li><a href="#" class="text-slate-400 hover:text-[#FFD166] transition-colors text-sm">About Us</a></li>
                    <li><a href="#" class="text-slate-400 hover:text-[#FFD166] transition-colors text-sm">Careers</a></li>
                    <li><a href="#" class="text-slate-400 hover:text-[#FFD166] transition-colors text-sm">Blog</a></li>
                    <li><a href="#" class="text-slate-400 hover:text-[#FFD166] transition-colors text-sm">Contact</a></li>
                    <li><a href="#" class="text-slate-400 hover:text-[#FFD166] transition-colors text-sm">Partners</a></li>
                </ul>
            </div>

            <!-- Contacts -->
            <div class="lg:col-span-1">
                <h4 class="text-white font-semibold text-lg mb-5">Contact Us</h4>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-[#FF52A7]/10 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-[#FF52A7]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <span class="text-slate-400 text-sm leading-relaxed">123 Travel Avenue, Suite 400<br>San Francisco, CA 94105</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-[#C9A84C]/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-[#C9A84C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <a href="mailto:hello@triptogether.demo" class="text-slate-400 hover:text-white transition-colors text-sm font-medium">hello@triptogether.demo</a>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-[#7C3AED]/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-[#7C3AED]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        </div>
                        <a href="tel:+18005550199" class="text-slate-400 hover:text-white transition-colors text-sm font-medium">+1 (800) 555-0199</a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="pt-8 border-t border-white/10 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-slate-500 text-sm">© {{ date('Y') }} TripTogether. All rights reserved.</p>
            <div class="flex items-center gap-5">
                <a href="#" class="text-slate-500 hover:text-[#FF52A7] transition-colors group"><span class="sr-only">Twitter</span><svg class="w-5 h-5 group-hover:-translate-y-1 transition-transform" fill="currentColor" viewBox="0 0 24 24"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/></svg></a>
                <a href="#" class="text-slate-500 hover:text-[#FF52A7] transition-colors group"><span class="sr-only">Instagram</span><svg class="w-5 h-5 group-hover:-translate-y-1 transition-transform" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd"/></svg></a>
                <a href="#" class="text-slate-500 hover:text-[#FF52A7] transition-colors group"><span class="sr-only">GitHub</span><svg class="w-5 h-5 group-hover:-translate-y-1 transition-transform" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"/></svg></a>
            </div>
        </div>
    </div>
</footer>
