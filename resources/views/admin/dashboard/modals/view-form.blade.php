<div x-show="$store.modal.current === 'view-form'"
     class="fixed inset-0 z-50 overflow-y-auto"
     x-cloak>
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="$store.modal.close()"></div>

        <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                <h3 class="text-lg font-medium leading-6 text-gray-900" x-text="'View ' + $store.modal.data.type"></h3>

                <div class="mt-4 space-y-4">
                    <template x-if="$store.modal.data.type === 'purchase_agreement'">
                        @include('admin.dashboard.modals.form-types.purchase-agreement')
                    </template>

                    <template x-if="$store.modal.data.type === 'property_disclosure'">
                        @include('admin.dashboard.modals.form-types.property-disclosure')
                    </template>

                    <template x-if="$store.modal.data.type === 'contact_inquiry'">
                        @include('admin.dashboard.modals.form-types.contact-inquiry')
                    </template>
                </div>
            </div>

            <div class="px-4 py-3 bg-gray-50 sm:px-6">
                <button type="button"
                        @click="$store.modal.close()"
                        class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:w-auto sm:text-sm">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
