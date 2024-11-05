@extends('layouts.app')

@section('content')
<div class="relative min-h-screen bg-cover bg-center flex items-center justify-center" style="background-image: url('{{ asset('uploads/uploads/propertiescover.jpg') }}');">
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    <div class="container mx-auto px-4 z-10">
        <div class="flex flex-col items-center justify-center text-center">
            <div class="p-8 bg-white bg-opacity-20 backdrop-filter backdrop-blur-md rounded-lg max-w-4xl w-full">
                <h1 class="text-4xl md:text-6xl font-bold mb-6 text-white">Real Estate Forms</h1>
                <p class="text-xl text-white mb-8">
                    We understand that real estate transactions involve a lot of paperwork. To make the process easier for you, we have compiled a list of commonly used real estate forms. Whether you're buying or selling a property, you'll find the forms you need here.
                </p>
                <a href="#forms" class="bg-white text-primary px-8 py-3 rounded-lg font-semibold hover:bg-gray-200 transition duration-300">
                    View Forms
                </a>
            </div>
        </div>
    </div>
</div>

<div id="forms" class="relative container mx-auto px-4 py-12">
    @if(session('info'))
        <div class="max-w-4xl mx-auto mb-6">
            <div class="bg-white bg-opacity-95 border-l-4 border-green-600 p-4 rounded-md backdrop-filter backdrop-blur-lg">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-gray-800">{{ session('info') }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div x-data="formsData()" class="relative max-w-4xl mx-auto">
        <div class="bg-[#052e16] bg-opacity-90 backdrop-filter backdrop-blur-xl rounded-xl shadow-2xl p-8 border border-green-700">
            <div class="relative z-10">
                <div class="bg-white bg-opacity-95 rounded-lg p-6 mb-8">
                    <p class="text-gray-800 text-lg leading-relaxed">
                        Our team is dedicated to providing you with the best service possible. If you have any questions about these forms or need assistance filling them out, please don't hesitate to reach out to us. We'll get back to you as soon as possible and guide you through the process.
                    </p>
                </div>

                <div class="mb-8">
                    <h2 class="text-white text-2xl font-semibold mb-6">Select a Form</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($categories as $category => $forms)
                            <div class="space-y-4">
                                <h3 class="text-white font-semibold text-lg">{{ $category }}</h3>
                                @foreach($forms as $formKey => $formName)
                                    <button
                                        @click="selectedForm = '{{ $formKey }}'; loadForm()"
                                        :class="{
                                            'bg-green-700 border-green-500 shadow-lg': selectedForm === '{{ $formKey }}',
                                            'bg-white/10 hover:bg-white/20 border-green-700': selectedForm !== '{{ $formKey }}'
                                        }"
                                        class="w-full flex items-center p-4 rounded-lg border-2 transition-all duration-300 group">
                                        <span class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-full bg-white/20 group-hover:bg-white/30 transition-colors duration-300">
                                            @if(str_contains($formKey, 'listing'))
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                </svg>
                                            @elseif(str_contains($formKey, 'property'))
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                            @elseif(str_contains($formKey, 'purchase'))
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            @elseif(str_contains($formKey, 'contact'))
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                                </svg>
                                            @endif
                                        </span>
                                        <span class="ml-4 text-left">
                                            <span class="block text-white text-lg font-medium">{{ $formName }}</span>
                                        </span>
                                    </button>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Form display area -->
                    <div x-show="formContent" x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 transform scale-100"
                         x-transition:leave-end="opacity-0 transform scale-95"
                         x-html="formContent"
                         class="mt-8 bg-white bg-opacity-95 rounded-lg p-6 backdrop-filter backdrop-blur-md border border-green-700">
                    </div>

                    <div x-show="loading" class="mt-8 flex justify-center">
                        <div class="inline-flex items-center px-4 py-2 bg-white bg-opacity-90 rounded-lg">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-green-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text-gray-800 font-medium">Loading form...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @section('scripts')
    <script>
    function formsData() {
        return {
            selectedForm: '{{ session('info') ? 'contact-inquiry' : '' }}',
            formContent: '',
            loading: false,
            async loadForm() {
                if (this.selectedForm) {
                    this.loading = true;
                    try {
                        const response = await fetch(`/forms/${this.selectedForm}`);
                        if (response.ok) {
                            this.formContent = await response.text();
                        } else {
                            throw new Error('Error loading form');
                        }
                    } catch (error) {
                        console.error('Error loading form:', error);
                        this.formContent = '<p class="text-red-500">Error loading form. Please try again.</p>';
                    } finally {
                        this.loading = false;
                    }
                } else {
                    this.formContent = '';
                }
            },
            init() {
                if (this.selectedForm === 'contact-inquiry') {
                    this.loadForm();
                }
            }
        }
    }
    </script>
    @endsection
