<x-app-layout>
    <div class="max-w-lg mx-auto bg-white shadow-lg p-6 rounded-lg mt-10">
        <h1 class="text-2xl font-bold mb-4">Send SMS</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('sms.send') }}">
            @csrf

            <label class="block mb-2">Content</label>
            <textarea name="content" class="w-full border p-2 mb-3"></textarea>

            <label class="block mb-2">Addresses (comma separated)</label>
            <input type="text" name="addresses" class="w-full border p-2 mb-3">

            <label class="block mb-2">Sender ID</label>
            <input type="text" name="sender" class="w-full border p-2 mb-3">

            <label class="block mb-2">Send Time</label>
            <input type="datetime-local" name="sendTime" class="w-full border p-2 mb-3">

            <label class="block mb-2">Callback URL</label>
            <input type="text" name="callbackUrl" class="w-full border p-2 mb-3">

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Send SMS</button>
        </form>
    </div>
</x-app-layout>
