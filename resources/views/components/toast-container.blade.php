<div
    x-data="toastManager()"
    @toast.window="addToast($event.detail)"
    class="fixed top-0 right-0 z-999999 flex flex-col items-end space-y-4 p-6"
    wire:ignore
>
    <template x-for="toast in toasts" :key="toast.id">
        <div
            x-show="toast.show"
            x-transition:enter="transform ease-out duration-300 transition"
            x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
            x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg shadow-lg ring-1 ring-black/5"
            :class="{
                'bg-green-50 dark:bg-green-900/20 border-green-200 dark:border-green-800': toast.type === 'success',
                'bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-800': toast.type === 'error',
                'bg-yellow-50 dark:bg-yellow-900/20 border-yellow-200 dark:border-yellow-800': toast.type === 'warning',
                'bg-blue-50 dark:bg-blue-900/20 border-blue-200 dark:border-blue-800': toast.type === 'info'
            }"
        >
            <div class="p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <!-- Success Icon -->
                        <svg x-show="toast.type === 'success'" class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <!-- Error Icon -->
                        <svg x-show="toast.type === 'error'" class="h-6 w-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <!-- Warning Icon -->
                        <svg x-show="toast.type === 'warning'" class="h-6 w-6 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                        <!-- Info Icon -->
                        <svg x-show="toast.type === 'info'" class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0zm-9-3.75h.008v.008H12V8.25z" />
                        </svg>
                    </div>
                    <div class="ml-3 w-0 flex-1 pt-0.5 min-w-[230px]">
                        <p x-show="toast.title" x-text="toast.title" class="text-sm font-medium"
                           :class="{
                               'text-green-800 dark:text-green-200': toast.type === 'success',
                               'text-red-800 dark:text-red-200': toast.type === 'error',
                               'text-yellow-800 dark:text-yellow-200': toast.type === 'warning',
                               'text-blue-800 dark:text-blue-200': toast.type === 'info'
                           }"></p>
                        <p x-text="toast.message" class="mt-1 text-sm"
                           :class="{
                               'text-green-700 dark:text-green-300': toast.type === 'success',
                               'text-red-700 dark:text-red-300': toast.type === 'error',
                               'text-yellow-700 dark:text-yellow-300': toast.type === 'warning',
                               'text-blue-700 dark:text-blue-300': toast.type === 'info'
                           }"></p>
                    </div>
                    <div class="ml-4 flex flex-shrink-0">
                        <button
                            type="button"
                            class="inline-flex rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                            @click="removeToast(toast.id)"
                        >
                            <span class="sr-only">Close</span>
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>

<script>
function toastManager() {
    return {
        toasts: [],
        nextId: 1,

        addToast(toast) {
            const id = this.nextId++;
            const newToast = {
                id,
                show: true,
                type: toast.type || 'success',
                title: toast.title || '',
                message: toast.message || '',
                duration: toast.duration || 5000
            };

            this.toasts.push(newToast);

            // Auto remove after duration
            setTimeout(() => {
                this.removeToast(id);
            }, newToast.duration);
        },

        removeToast(id) {
            const index = this.toasts.findIndex(toast => toast.id === id);
            if (index > -1) {
                this.toasts[index].show = false;
                // Remove from array after animation
                setTimeout(() => {
                    this.toasts.splice(index, 1);
                }, 300);
            }
        }
    }
}
</script>
