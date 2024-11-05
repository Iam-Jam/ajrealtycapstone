{{-- resources/views/components/admin/user-menu.blade.php --}}
<div x-data="{ open: false }" class="relative">
    <button @click="open = !open" class="flex items-center">
        <span class="mr-2 text-gray-700">{{ Auth::user()->name }}</span>
        <x-icon name="chevron-down" class="w-4 h-4 text-gray-500" />
    </button>

    <div x-show="open"
         @click.away="open = false"
         class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1">
        <a href="{{ route('profile.edit') }}"
           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
            {{ __('Profile') }}
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                {{ __('Logout') }}
            </button>
        </form>
    </div>
</div>
