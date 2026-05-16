<div
    x-data="toastManager()"
    @notify.window="addToast($event.detail.message, $event.detail.type || 'success')"
    class="fixed bottom-0 right-0 z-[999] p-4 space-y-3 w-full max-w-sm pointer-events-none flex flex-col items-end"
>
    <template x-for="toast in toasts" :key="toast.id">
        <div
            x-show="toast.visible"
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 translate-y-8 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-8 scale-95"
            class="flex items-center w-full max-w-sm p-4 text-slate-600 bg-white rounded-xl shadow-xl border border-slate-100 dark:text-slate-300 dark:bg-slate-800 dark:border-slate-700 pointer-events-auto"
            role="alert"
        >
            <!-- icon -->
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg"
                 :class="{
                    'text-emerald-600 bg-emerald-100 dark:bg-emerald-900/50 dark:text-emerald-400': toast.type === 'success',
                    'text-red-600 bg-red-100 dark:bg-red-900/50 dark:text-red-400': toast.type === 'error',
                    'text-blue-600 bg-blue-100 dark:bg-blue-900/50 dark:text-blue-400': toast.type === 'info',
                 }"
            >
                <!-- success icon -->
                <svg x-show="toast.type === 'success'" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <!-- error icon -->
                <svg x-show="toast.type === 'error'" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <!-- info icon -->
                <svg x-show="toast.type === 'info'" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            
            <div class="ml-3 text-sm font-medium text-slate-800 dark:text-white" x-text="toast.message"></div>
            
            <button @click="removeToast(toast.id)" type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-slate-400 hover:text-slate-900 rounded-lg focus:ring-2 focus:ring-slate-300 p-1.5 hover:bg-slate-100 inline-flex h-8 w-8 dark:text-slate-500 dark:hover:text-white dark:bg-slate-800 dark:hover:bg-slate-700 transition-colors">
                <span class="sr-only">Close</span>
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
        </div>
    </template>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('toastManager', () => ({
                toasts: [],
                addToast(message, type = 'success') {
                    const id = Date.now();
                    this.toasts.push({ id, message, type, visible: true });
                    
                    setTimeout(() => {
                        this.removeToast(id);
                    }, 4000);
                },
                removeToast(id) {
                    const toast = this.toasts.find(t => t.id === id);
                    if (toast) toast.visible = false;
                    setTimeout(() => {
                        this.toasts = this.toasts.filter(t => t.id !== id);
                    }, 300); // Wait for transition
                }
            }));
        });
    </script>
    
    <!-- Initial Server-side toasts -->
    @if(session('success'))
        <div x-init="$nextTick(() => addToast({!! json_encode(session('success')) !!}, 'success'))"></div>
    @endif
    @if(session('error'))
        <div x-init="$nextTick(() => addToast({!! json_encode(session('error')) !!}, 'error'))"></div>
    @endif
    @if(session('info'))
        <div x-init="$nextTick(() => addToast({!! json_encode(session('info')) !!}, 'info'))"></div>
    @endif
</div>
