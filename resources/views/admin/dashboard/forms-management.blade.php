{{-- resources/views/admin/dashboard/forms-management.blade.php --}}
<div class="space-y-6">
    <!-- Form Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Purchase Agreements</h3>
            <div class="flex justify-between items-center">
                <span class="text-2xl font-bold text-gray-900">{{ $formStats['purchaseAgreements'] ?? 0 }}</span>
                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Active</span>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Property Disclosures</h3>
            <div class="flex justify-between items-center">
                <span class="text-2xl font-bold text-gray-900">{{ $formStats['propertyDisclosures'] ?? 0 }}</span>
                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Active</span>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Contact Inquiries</h3>
            <div class="flex justify-between items-center">
                <span class="text-2xl font-bold text-gray-900">{{ $formStats['contactInquiries'] ?? 0 }}</span>
                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Pending</span>
            </div>
        </div>
    </div>

    <!-- Forms List -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="flex justify-between items-center p-4 border-b border-gray-200">
            <div class="flex space-x-4">
                <select x-model="selectedFormType" class="rounded-md border-gray-300 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                    <option value="">All Form Types</option>
                    <option value="purchase_agreement">Purchase Agreement</option>
                    <option value="property_disclosure">Property Disclosure</option>
                    <option value="contact_inquiry">Contact Inquiry</option>
                </select>
                <select x-model="selectedStatus" class="rounded-md border-gray-300 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                    <option value="">All Statuses</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
        </div>

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Form ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted By</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($forms ?? [] as $form)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">#{{ $form->id }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $form->type)) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $form->user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $form->user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $form->created_at->format('M d, Y') }}</div>
                            <div class="text-sm text-gray-500">{{ $form->created_at->format('h:i A') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $form->status === 'approved' ? 'bg-green-100 text-green-800' :
                                   ($form->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($form->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <button @click="$dispatch('open-modal', {name: 'view-form', form: {{ $form }})"
                                    class="text-blue-600 hover:text-blue-900">
                                View
                            </button>
                            @if($form->status === 'pending')
                                <form action="{{ route('admin.forms.approve', $form) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-900">Approve</button>
                                </form>
                                <form action="{{ route('admin.forms.reject', $form) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:text-red-900">Reject</button>
                                </form>
                            @endif
                            <form action="{{ route('admin.forms.delete', $form) }}"
                                  method="POST"
                                  class="inline"
                                  onsubmit="return confirm('Are you sure you want to delete this form?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            No forms found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($forms ?? false)
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $forms->links() }}
            </div>
        @endif
    </div>
</div>
