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

    <!-- Message Sending Tabs -->
    <div x-data="{ tab: 'contact' }" class="space-y-6 mt-8 bg-white shadow rounded-xl p-6">

        {{-- Tab Navigation --}}
        <div class="flex gap-2">
            <button type="button" @click="tab='contact'" :class="tab==='contact' ? 'bg-indigo-600 text-white' : 'bg-gray-100'" class="px-4 py-2 rounded-lg font-medium">Contact List</button>
            <button type="button" @click="tab='tier'" :class="tab==='tier' ? 'bg-indigo-600 text-white' : 'bg-gray-100'" class="px-4 py-2 rounded-lg font-medium">Tier Level</button>
            <button type="button" @click="tab='recipient'" :class="tab==='recipient' ? 'bg-indigo-600 text-white' : 'bg-gray-100'" class="px-4 py-2 rounded-lg font-medium">Recipient Type</button>
        </div>

        <form method="POST" action="{{ route('admin.messages.templates.send', $message) }}" class="space-y-5">
            @csrf

            <input type="hidden" name="send_mode" x-bind:value="tab === 'contact' ? 'contact_list' : 'custom'">

            {{-- CONTACT TAB --}}
            <div x-show="tab === 'contact'" x-cloak>
                <label class="block text-sm font-medium text-gray-700 mb-1">Send Message To</label>
                <select name="contact_list_id" class="w-full rounded-lg border-gray-300 shadow-sm p-3">
                    <option value="">-- Select Contact List --</option>
                    @foreach($contactLists as $list)
                    <option value="{{ $list->id }}">{{ $list->title }} ({{ $list->user_count }})</option>
                    @endforeach
                </select>
            </div>

            {{-- TIER TAB --}}
            <div x-show="tab === 'tier'" x-cloak>
                <label class="block text-sm font-medium text-gray-700 mb-1">Select Tier Level</label>
                <select name="reward_level" class="w-full rounded-lg border-gray-300 shadow-sm p-3">
                    <option value="">-- Select Tier Level --</option>
                    @foreach($rewardLevels as $level)
                    <option value="{{ $level->id }}">{{ $level->title }}</option>
                    @endforeach
                </select>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3">
                    <input type="text" id="start_date" name="start_date" placeholder="Start Date" class="rounded-lg border-gray-300 shadow-sm p-3" />
                    <input type="text" id="end_date" name="end_date" placeholder="End Date" class="rounded-lg border-gray-300 shadow-sm p-3" />
                </div>
            </div>

            {{-- RECIPIENT TAB --}}
            <div x-show="tab === 'recipient'" x-cloak x-data="{ recipientType: '' }">
                <label class="block text-sm font-medium text-gray-700 mb-1">Recipient Type</label>
                <select name="recipient_type" x-model="recipientType" class="w-full rounded-lg border-gray-300 shadow-sm p-3">
                    <option value="">-- Select Recipient Type --</option>
                    <option value="all">All Users</option>
                    <option value="individual">Individual Users</option>
                </select>

                <div x-show="recipientType === 'individual'" x-cloak class="mt-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Select Users</label>
                    <select name="users[]" id="users" multiple class="w-full rounded-lg border-gray-300 shadow-sm p-3"></select>
                </div>
            </div>


            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg shadow font-medium transition">
                🚀 Send Message
            </button>
        </form>

        {{-- Divider + Test Form --}}
        <div class="flex items-center space-x-2 text-gray-400">
            <div class="flex-1 h-px bg-gray-200"></div>
            <span class="text-xs">OR</span>
            <div class="flex-1 h-px bg-gray-200"></div>
        </div>

        <form method="POST" action="{{ route('admin.messages.templates.test', $message) }}" class="space-y-4">
            @csrf
            <label for="test_email" class="block text-sm font-medium text-gray-700 mb-1">Test Email Address</label>
            <div class="flex rounded-lg shadow-sm">
                <input type="email" id="test_email" name="test_email" value="hello@watchlocker.biz" class="flex-1 rounded-l-lg border-gray-300 px-3 py-2 text-sm" placeholder="Enter email" required>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-r-lg font-medium">
                    ✉️ Send Test
                </button>
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

<script>
    document.addEventListener('alpine:init', () => {
        // Initialize flatpickr
        if (typeof flatpickr !== 'undefined') {
            flatpickr("#start_date", {
                dateFormat: "Y-m-d"
                , maxDate: "today"
            });
            flatpickr("#end_date", {
                dateFormat: "Y-m-d"
                , maxDate: "today"
            });
        } else {
            console.error('Flatpickr not loaded.');
        }

        // Initialize Select2 AJAX for user search
        $('#users').select2({
            placeholder: 'Search and select users...'
            , ajax: {
                url: '{!! route("admin.users.search") !!}'
                , dataType: 'json'
                , delay: 300
                , data: params => ({
                    query: params.term
                })
                , processResults: data => ({
                    results: data.map(user => ({
                        id: user.id
                        , text: `${user.first_name} ${user.last_name} (${user.email || user.phone || 'No contact'})`
                    }))
                })
                , cache: true
            }
            , minimumInputLength: 2
        });
    });

</script>

@endpush
