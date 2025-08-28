<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p class="text-gray-900 dark:text-gray-100 mb-4">
                    Welcome.
                </p>

                <!-- Bulk SMS Button -->
                <a href="{{ route('sms.index') }}"
                   class="inline-block px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700">
                    Go to Bulk SMS.
                </a>
                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}" class="inline-block ml-4">
                    @csrf
                    <button type="submit"
                            class="px-6 py-3 bg-red-600 text-white font-semibold rounded-lg shadow hover:bg-red-700">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
