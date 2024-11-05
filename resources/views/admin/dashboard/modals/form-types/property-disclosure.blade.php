{{-- resources/views/admin/dashboard/modals/form-types/property-disclosure.blade.php --}}
<div class="space-y-4">
    <div class="border-b border-gray-200 pb-4">
        <h4 class="text-sm font-medium text-gray-500">Property Information</h4>
        <div class="mt-2">
            <p class="text-sm text-gray-500">Property Address</p>
            <p class="text-sm font-medium text-gray-900" x-text="$store.modal.data.property_address"></p>
        </div>
        <div class="mt-2">
            <p class="text-sm text-gray-500">Seller Name</p>
            <p class="text-sm font-medium text-gray-900" x-text="$store.modal.data.seller_name"></p>
        </div>
    </div>

    <div class="border-b border-gray-200 pb-4">
        <h4 class="text-sm font-medium text-gray-500">Structural Issues</h4>
        <div class="mt-2 space-y-2">
            <template x-for="(value, key) in $store.modal.data.structural_issues" :key="key">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-red-500" x-show="value" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"/>
                    </svg>
                    <span class="ml-2 text-sm text-gray-900" x-text="key.replace('_', ' ')"></span>
                </div>
            </template>
        </div>
    </div>

    <div class="border-b border-gray-200 pb-4">
        <h4 class="text-sm font-medium text-gray-500">System Issues</h4>
        <div class="mt-2 space-y-2">
            <template x-for="(value, key) in $store.modal.data.system_issues" :key="key">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-red-500" x-show="value" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"/>
                    </svg>
                    <span class="ml-2 text-sm text-gray-900" x-text="key.replace('_', ' ')"></span>
                </div>
            </template>
        </div>
    </div>

    <div>
        <h4 class="text-sm font-medium text-gray-500">Additional Issues</h4>
        <p class="mt-2 text-sm text-gray-900" x-text="$store.modal.data.additional_issues"></p>
    </div>
</div>
