<div x-data="notificationSystem()"
     @show-notification.window="show($event.detail)"
     class="fixed inset-x-0 bottom-4 flex justify-center z-50">
    <div x-show="visible"
         x-transition:enter="transform ease-out duration-300"
         x-transition:enter-start="translate-y-2 opacity-0"
         x-transition:enter-end="translate-y-0 opacity-100"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         :class="notificationClasses"
         class="rounded-lg shadow-lg p-4 max-w-md">
        <div class="flex items-center">
            <div class="flex-1" x-text="message"></div>
            <button @click="hide" class="ml-4">
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
function notificationSystem() {
    return {
        visible: false,
        message: '',
        type: 'success',
        timeout: null,

        get notificationClasses() {
            return {
                'success': 'bg-green-100 border border-green-400 text-green-700',
                'error': 'bg-red-100 border border-red-400 text-red-700',
                'warning': 'bg-yellow-100 border border-yellow-400 text-yellow-700'
            }[this.type];
        },

        show(data) {
            this.message = data.message;
            this.type = data.type || 'success';
            this.visible = true;

            if (this.timeout) clearTimeout(this.timeout);
            this.timeout = setTimeout(() => this.hide(), 5000);
        },

        hide() {
            this.visible = false;
        }
    }
}
</script>
@endpush
