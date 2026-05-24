{{-- Tabs Navigation (Premium Segmented Toggle) --}}
    <div class="p-1.5 bg-slate-100/80 backdrop-blur-md rounded-2xl w-full xl:w-max border border-slate-200/50 shadow-inner overflow-x-auto">
        <div class="relative flex w-full min-w-[320px]">
            <!-- Background Slider (5 tabs: each 20%) -->
            <div class="absolute top-0 bottom-0 left-0 bg-white rounded-xl shadow-sm transition-transform duration-300 ease-out pointer-events-none"
                 :style="
                     activeTab === 'overview' ? 'width:20%; transform: translateX(0%);' :
                     activeTab === 'itinerary' ? 'width:20%; transform: translateX(100%);' :
                     activeTab === 'members' ? 'width:20%; transform: translateX(200%);' :
                     activeTab === 'budget' ? 'width:20%; transform: translateX(300%);' :
                     'width:20%; transform: translateX(400%);'
                 "></div>

            <button type="button" @click.prevent="activeTab = 'overview'" 
                    :class="activeTab === 'overview' ? 'text-[#FF52A7]' : 'text-slate-500 hover:text-slate-800'" 
                    class="relative flex-1 flex items-center justify-center gap-2 px-2 md:px-6 py-2.5 rounded-xl text-xs md:text-sm font-bold transition-colors duration-300 z-10 whitespace-nowrap cursor-pointer">
                <svg class="w-4 h-4 hidden md:block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Overview
            </button>
            <button type="button" @click.prevent="activeTab = 'itinerary'" 
                    :class="activeTab === 'itinerary' ? 'text-[#FF52A7]' : 'text-slate-500 hover:text-slate-800'" 
                    class="relative flex-1 flex items-center justify-center gap-2 px-2 md:px-6 py-2.5 rounded-xl text-xs md:text-sm font-bold transition-colors duration-300 z-10 whitespace-nowrap cursor-pointer">
                <svg class="w-4 h-4 hidden md:block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Itinerary
            </button>
            <button type="button" @click.prevent="activeTab = 'members'" 
                    :class="activeTab === 'members' ? 'text-[#FF52A7]' : 'text-slate-500 hover:text-slate-800'" 
                    class="relative flex-1 flex items-center justify-center gap-2 px-2 md:px-6 py-2.5 rounded-xl text-xs md:text-sm font-bold transition-colors duration-300 z-10 whitespace-nowrap cursor-pointer">
                <svg class="w-4 h-4 hidden md:block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Members
            </button>
            <button type="button" @click.prevent="activeTab = 'budget'" 
                    :class="activeTab === 'budget' ? 'text-[#FF52A7]' : 'text-slate-500 hover:text-slate-800'" 
                    class="relative flex-1 flex items-center justify-center gap-2 px-2 md:px-6 py-2.5 rounded-xl text-xs md:text-sm font-bold transition-colors duration-300 z-10 whitespace-nowrap cursor-pointer">
                <svg class="w-4 h-4 hidden md:block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Budget
            </button>
            <button type="button" @click.prevent="activeTab = 'settlements'" 
                    :class="activeTab === 'settlements' ? 'text-[#FF52A7]' : 'text-slate-500 hover:text-slate-800'" 
                    class="relative flex-1 flex items-center justify-center gap-2 px-2 md:px-6 py-2.5 rounded-xl text-xs md:text-sm font-bold transition-colors duration-300 z-10 whitespace-nowrap cursor-pointer">
                <svg class="w-4 h-4 hidden md:block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Settlements
            </button>
        </div>
    </div>