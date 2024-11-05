<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'AJ Real Estate') }}</title>

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@alpinejs/mask@3.10.2/dist/cdn.min.js" defer></script>

    @yield('additional_head')
    @yield('styles')
</head>
<body class="bg-gray-100 font-sans flex flex-col min-h-screen">
    @include('partials.header')

    <!-- Global Notification System -->
    <div x-data="notificationSystem()"
         @show-notification.window="show($event.detail)"
         class="fixed inset-x-0 top-20 flex items-center justify-center px-4 py-6 z-50 pointer-events-none">

        <template x-if="visible">
            <div :class="notificationClasses"
                 class="rounded-lg shadow-lg p-4 max-w-md w-full pointer-events-auto"
                 x-transition:enter="transform ease-out duration-300"
                 x-transition:enter-start="translate-y-2 opacity-0"
                 x-transition:enter-end="translate-y-0 opacity-100"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0">
                <div class="flex items-center">
                    <div class="flex-1">
                        <div class="text-sm font-medium" x-text="message"></div>
                    </div>
                    <button @click="hide" class="ml-4 text-current hover:opacity-75">
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            </div>
        </template>
    </div>

    <div id="app" class="flex-grow">
        <main class="py-4">
            <div class="container mx-auto">
                @yield('content')
            </div>
        </main>
    </div>

    @include('partials.footer')

    @auth
        @if (auth()->user()->is_admin)
            <span class="hidden">Admin</span>
        @endif
    @endauth

    <!-- Core Scripts -->
    <script>
        function notificationSystem() {
            return {
                visible: false,
                message: '',
                type: 'success',
                timeout: null,

                get notificationClasses() {
                    const classes = {
                        'success': 'bg-green-100 border-l-4 border-green-500 text-green-700',
                        'error': 'bg-red-100 border-l-4 border-red-500 text-red-700',
                        'warning': 'bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700',
                        'info': 'bg-blue-100 border-l-4 border-blue-500 text-blue-700'
                    };
                    return classes[this.type] || classes.info;
                },

                init() {
                    @if (session('success'))
                        this.show({ message: "{{ session('success') }}", type: 'success' });
                    @endif
                    @if (session('error'))
                        this.show({ message: "{{ session('error') }}", type: 'error' });
                    @endif
                    @if (session('warning'))
                        this.show({ message: "{{ session('warning') }}", type: 'warning' });
                    @endif
                    @if (session('info'))
                        this.show({ message: "{{ session('info') }}", type: 'info' });
                    @endif
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

    @yield('scripts')
</body>
</html>
