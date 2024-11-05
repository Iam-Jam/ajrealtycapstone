<div class="space-y-4">
    <div class="border-b border-gray-200 pb-4">
        <h4 class="text-sm font-medium text-gray-500">Purchase Agreement Details</h4>
        <div class="mt-2 grid grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500">Buyer Name</p>
                <p class="text-sm font-medium text-gray-900" x-text="$store.modal.data.buyer_name"></p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Seller Name</p>
                <p class="text-sm font-medium text-gray-900" x-text="$store.modal.data.seller_name"></p>
            </div>
        </div>
    </div>

    <div class="border-b border-gray-200 pb-4">
        <h4 class="text-sm font-medium text-gray-500">Property Information</h4>
        <div class="mt-2">
            <p class="text-sm text-gray-500">Property Address</p>
            <p class="text-sm font-medium text-gray-900" x-text="$store.modal.data.property_address"></p>
        </div>
        <div class="mt-2 grid grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500">Purchase Price</p>
                <p class="text-sm font-medium text-gray-900" x-text="'₱' + Number($store.modal.data.purchase_price).toLocaleString()"></p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Closing Date</p>
                <p class="text-sm font-medium text-gray-900" x-text="$store.modal.data.closing_date"></p>
            </div>
        </div>
    </div>

    <div class="border-b border-gray-200 pb-4">
        <h4 class="text-sm font-medium text-gray-500">Terms & Conditions</h4>
        <div class="mt-2">
            <p class="text-sm text-gray-500">Payment Terms</p>
            <p class="text-sm font-medium text-gray-900" x-text="$store.modal.data.payment_terms"></p>
        </div>
        <div class="mt-2">
            <p class="text-sm text-gray-500">Contingencies</p>
            <p class="text-sm font-medium text-gray-900" x-text="$store.modal.data.contingencies"></p>
        </div>
    </div>

    <div>
        <h4 class="text-sm font-medium text-gray-500">Additional Notes</h4>
        <p class="mt-2 text-sm text-gray-900" x-text="$store.modal.data.additional_notes"></p>
    </div>
</div>
