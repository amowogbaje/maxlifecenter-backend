@extends('admin.layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Preview Message</h1>
        <a href="{{ route('admin.messages.templates.index') }}" class="text-sm text-blue-600 hover:underline">
            ← Back to Messages
        </a>
    </div>

    <!-- Message Card -->
    <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-gray-100">
        <div class="px-6 py-4 border-b bg-gray-50">
            <h2 class="text-lg font-semibold text-gray-700">{{ $message->subject }}</h2>
        </div>
        <div class="px-6 py-6 prose max-w-none text-gray-700">
            {!! nl2br(e($message->body)) !!}
        </div>
    </div>

    <!-- Actions -->
    <div class="mt-8 bg-white shadow rounded-xl p-6 space-y-6">
        <form method="POST" action="{{ route('admin.messages.templates.send', $message) }}" class="space-y-5" id="messageForm">
            @csrf

            {{-- Contact List Selection --}}
            <div>
                <label for="contact_list_id" class="block text-sm font-medium text-gray-700 mb-1">
                    Send Message To
                </label>
                <select name="contact_list_id" id="contact_list_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3" required>
                    <option value="">-- Select Contact List --</option>
                    @foreach($contactLists as $list)
                    <option value="{{ $list->id }}">{{ $list->title }} ({{$list->user_count}})</option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-500 mt-1">
                    Select a predefined contact list to send this message to.
                </p>
            </div>

            {{-- Submit Button --}}
            <div class="flex items-center space-x-3">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg shadow font-medium transition">
                    🚀 Send Message
                </button>
            </div>
        </form>


        <!-- Divider -->
        <div class="flex items-center space-x-2 text-gray-400">
            <div class="flex-1 h-px bg-gray-200"></div>
            <span class="text-xs">OR</span>
            <div class="flex-1 h-px bg-gray-200"></div>
        </div>

        <!-- Send Test -->
        <form method="POST" action="{{ route('admin.messages.templates.test', $message) }}" class="space-y-4">
            @csrf
            <div>
                <label for="test_email" class="block text-sm font-medium text-gray-700 mb-1">Test Email Address</label>
                <div class="flex rounded-lg shadow-sm">
                    <input type="email" id="test_email" name="test_email" value="hello@watchlocker.biz" class="flex-1 rounded-l-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm px-3 py-2" placeholder="Enter email address" required>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-r-lg font-medium">
                        ✉️ Send Test
                    </button>
                </div>
                <p class="mt-1 text-xs text-gray-500">We’ll send a test message to this address.</p>
            </div>
        </form>
    </div>
</div>
@endsection

@push('script')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
