<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Bulk SMS Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- Back to Dashboard Button -->
                <a href="{{ route('dashboard') }}"
                   class="inline-block mb-4 px-6 py-3 bg-gray-600 text-white font-semibold rounded-lg shadow hover:bg-gray-700">
                    ← Back to Dashboard
                </a>

                {{-- Success Response --}}
                @if(session('response'))
                    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                        <pre>{{ json_encode(session('response'), JSON_PRETTY_PRINT) }}</pre>
                    </div>
                @endif

                {{-- Error Message --}}
                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- SMS Form --}}
                <form action="{{ route('sms.send') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block font-medium text-white">Sender ID</label>
                        <input type="text" name="sender" required
                               class="w-full border rounded p-2">
                    </div>

                    <div>
                        <label class="block font-medium text-white">Message</label>
                        <textarea name="content" required
                                  class="w-full border rounded p-2"></textarea>
                    </div>

                    <div>
                        <label class="block font-medium text-white">Recipients (comma separated)</label>
                        <input type="text" name="addresses[]" placeholder="254721000111,254722000222" required
                               class="w-full border rounded p-2">
                    </div>

                    <div>
                        <label class="block font-medium text-white">DND</label>
                        <select name="dnd" class="w-full border rounded p-2">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>

                    <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Send SMS
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
