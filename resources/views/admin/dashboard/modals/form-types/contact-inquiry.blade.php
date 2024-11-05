{{-- resources/views/admin/dashboard/modals/form-types/contact-inquiry.blade.php --}}
<div class="space-y-4">
    <div class="border-b border-gray-200 pb-4">
        <h4 class="text-sm font-medium text-gray-500">Contact Information</h4>
        <div class="mt-2 grid grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500">Full Name</p>
                <p class="text-sm font-medium text-gray-900" x-text="$store.modal.data.full_name"></p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Email</p>
                <p class="text-sm font-medium text-gray-900" x-text="$store.modal.data.email"></p>
            </div>
        </div>
        <div class="mt-2">
            <p class="text-sm text-gray-500">Phone</p>
            <p class="text-sm font-medium text-gray-900" x-text="$store.modal.data.phone"></p>
        </div>
    </div>

    <div class="border-b border-gray-200 pb-4">
        <h4 class="text-sm font-medium text-gray-500">Inquiry Details</h4>
        <div class="mt-2">
            <p class="text-sm text-gray-500">Property Address (if applicable)</p>
            <p class="text-sm font-medium text-gray-900" x-text="$store.modal.data.property_address || 'N/A'"></p>
        </div>
        <div class="mt-2">
            <p class="text-sm text-gray-500">Inquiry Type</p>
            <p class="text-sm font-medium text-gray-900" x-text="$store.modal.data.inquiry_type"></p>
        </div>
    </div>

    <div class="border-b border-gray-200 pb-4">
        <h4 class="text-sm font-medium text-gray-500">Message</h4>
        <p class="mt-2 text-sm text-gray-900" x-text="$store.modal.data.message"></p>
    </div>

    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-500">Status</p>
            <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                  :class="{
                      'bg-yellow-100 text-yellow-800': $store.modal.data.status === 'pending',
                      'bg-green-100 text-green-800': $store.modal.data.status === 'processed',
                      'bg-red-100 text-red-800': $store.modal.data.status === 'rejected'
                  }"
                  x-text="$store.modal.data.status">
            </span>
        </div>
        <div>
            <p class="text-sm text-gray-500">Submitted</p>
            <p class="text-sm font-medium text-gray-900" x-text="new Date($store.modal.data.created_at).toLocaleDateString()"></p>
        </div>
    </div>

    <div x-show="$store.modal.data.status === 'pending'" class="mt-4 flex space-x-3">
        <button @click="processInquiry($store.modal.data.id)"
                class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
            Process Inquiry
        </button>
        <button @click="rejectInquiry($store.modal.data.id)"
                class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
            Reject Inquiry
        </button>
    </div>
</div>
