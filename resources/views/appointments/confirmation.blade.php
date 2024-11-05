@component('mail::message')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg overflow-hidden">
            <div class="text-center bg-secondary px-6 py-8">
                <h1 class="text-2xl font-bold text-white">Appointment Confirmation</h1>
                <p class="mt-2 text-white opacity-90">Thank you for scheduling an appointment with us.</p>
            </div>

            <div class="p-6">
                <div class="space-y-4">
                    {{-- Name --}}
                    <div class="border-b border-gray-200 pb-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600 font-medium">Name:</span>
                            <span class="text-gray-900">{{ $appointment->name }}</span>
                        </div>
                    </div>

                    {{-- Date & Time --}}
                    <div class="border-b border-gray-200 pb-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600 font-medium">Date & Time:</span>
                            <span class="text-gray-900">
                                {{ $appointment->appointment_date->format('F j, Y g:i A') }}
                            </span>
                        </div>
                    </div>

                    {{-- Property --}}
                    <div class="border-b border-gray-200 pb-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600 font-medium">Property:</span>
                            <span class="text-gray-900">
                                {{ $appointment->property->title ?? 'Selected Property' }}
                            </span>
                        </div>
                    </div>

                    {{-- Phone (if available) --}}
                    @if($appointment->phone)
                    <div class="border-b border-gray-200 pb-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600 font-medium">Phone:</span>
                            <span class="text-gray-900">{{ $appointment->phone }}</span>
                        </div>
                    </div>
                    @endif

                    {{-- Notes (if available) --}}
                    @if($appointment->notes)
                    <div class="border-b border-gray-200 pb-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600 font-medium">Notes:</span>
                            <span class="text-gray-900">{{ $appointment->notes }}</span>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Call to Action Button --}}
                @component('mail::button', ['url' => route('home'), 'color' => 'secondary'])
                    Visit Our Website
                @endcomponent

                {{-- Contact Information --}}
                <div class="mt-8 text-center">
                    <p class="text-gray-600">
                        If you need to make changes to your appointment,<br>
                        please contact us at <span class="text-secondary font-medium">(209) 661-9494</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="mt-8 text-center text-gray-600">
        <p>Thank you for choosing our services!</p>
        <p class="mt-2">
            Best regards,<br>
            {{ config('app.name') }}
        </p>
    </div>
@endcomponent
