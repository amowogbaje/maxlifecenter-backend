@extends('admin.layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4">
    
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Preview Message</h1>
        <a href="{{ route('admin.messages.templates.index') }}" 
           class="flex items-center gap-1 text-blue-600 hover:text-blue-800 text-sm font-medium transition">
            <svg xmlns="http://www.w3.org/2000/svg" 
                 class="w-4 h-4" fill="none" viewBox="0 0 24 24" 
                 stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Messages
        </a>
    </div>

    <!-- Message Preview -->
    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b">
            <h2 class="text-xl font-semibold text-gray-800">{{ $message->subject ?? '(No Subject)' }}</h2>
        </div>
        <div class="px-6 py-6 text-gray-700 leading-relaxed whitespace-pre-line">
            {!! nl2br(e($message->body ?? 'No message content available.')) !!}
        </div>
    </div>

    <!-- Message Sending Section -->
    <div x-data="messageTabs()" x-ref="messageTabs" id="messageTabsRoot" class="mt-10 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-6">
   
        <!-- Tabs -->
        <div class="flex flex-wrap gap-2">
            <button type="button" 
                    @click="tab='contact'" 
                    :class="tab==='contact' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700'"
                    class="px-4 py-2 rounded-lg font-medium transition">Contact List</button>

            <button type="button" 
                    @click="tab='tier'" 
                    :class="tab==='tier' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700'"
                    class="px-4 py-2 rounded-lg font-medium transition">Tier Level</button>

            <button type="button" 
                    @click="tab='recipient'" 
                    :class="tab==='recipient' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700'"
                    class="px-4 py-2 rounded-lg font-medium transition">Recipient Type</button>
        </div>

        <!-- Send Message Form -->
        <form method="POST" action="{{ route('admin.messages.templates.send', $message) }}" class="space-y-5">
            @csrf
            <input type="hidden" name="send_mode" x-bind:value="tab === 'contact' ? 'contact_list' : 'custom'">

            {{-- Contact List --}}
            <div x-show="tab === 'contact'" x-cloak>
                <label class="block text-sm font-medium text-gray-700 mb-1">Send Message To</label>
                <select name="contact_list_id" class="w-full rounded-lg border-gray-300 shadow-sm p-3">
                    <option value="">-- Select Contact List --</option>
                    @foreach($contactLists as $list)
                        <option value="{{ $list->id }}">{{ $list->title }} ({{ $list->user_count }})</option>
                    @endforeach
                </select>
            </div>

            {{-- Tier Level --}}
            <div x-show="tab === 'tier'" x-cloak>
                <label class="block text-sm font-medium text-gray-700 mb-1">Select Tier Level</label>
                <select name="reward_id" x-model="tierId" @change="fetchCount('tier')" class="w-full rounded-lg border-gray-300 shadow-sm p-3">
                    <option value="">-- Select Tier Level --</option>
                    @foreach($rewardLevels as $level)
                        <option value="{{ $level->id }}">{{ $level->title }}</option>
                    @endforeach
                </select>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3">
                    <input type="text" id="start_date" name="start_date" x-model="startDate" @change="fetchCount('tier')" placeholder="Start Date" class="rounded-lg border-gray-300 shadow-sm p-3" />
                    <input type="text" id="end_date" name="end_date" x-model="endDate" @change="fetchCount('tier')" placeholder="End Date" class="rounded-lg border-gray-300 shadow-sm p-3" />
                </div>

                <p x-show="tierCount > 0"
                   class="text-sm text-gray-600 mt-2"
                   x-text="`👥 ${tierCount} user${tierCount > 1 ? 's' : ''}`"></p>
            </div>

            {{-- Recipient Type --}}
            <div x-show="tab === 'recipient'" x-cloak>
                <label class="block text-sm font-medium text-gray-700 mb-1">Recipient Type</label>
                <select name="recipient_type" x-model="recipientType" @change="fetchCount('recipient')" 
                        class="w-full rounded-lg border-gray-300 shadow-sm p-3">
                    <option value="">-- Select Recipient Type --</option>
                    <option value="all">All Users</option>
                    <option value="individual">Individual Users</option>
                </select>

                <p class="text-sm text-gray-600 mt-2" 
                   x-show="recipientCount > 0" 
                   x-text="`👥 ${recipientCount} user${recipientCount > 1 ? 's' : ''} selected`"></p>

                <div x-show="recipientType === 'individual'" x-cloak class="mt-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Select Users</label>
                    <select name="users[]" id="users" multiple class="w-full rounded-lg border-gray-300 shadow-sm p-3"></select>
                </div>
            </div>

            <button type="submit" 
                    class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg shadow font-medium transition">
                🚀 Send Message
            </button>
        </form>

        <!-- Divider -->
        <div class="flex items-center space-x-2 text-gray-400">
            <div class="flex-1 h-px bg-gray-200"></div>
            <span class="text-xs">OR</span>
            <div class="flex-1 h-px bg-gray-200"></div>
        </div>

        <!-- Test Message Form -->
        <form method="POST" action="{{ route('admin.messages.templates.test', $message) }}" class="space-y-4">
            @csrf
            <label for="test_email" class="block text-sm font-medium text-gray-700 mb-1">Test Email Address</label>
            <div class="flex rounded-lg shadow-sm overflow-hidden">
                <input type="email" id="test_email" name="test_email" value="hello@watchlocker.biz"
                       class="flex-1 border border-gray-300 px-3 py-2 text-sm focus:outline-none"
                       placeholder="Enter email" required>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 text-sm font-medium transition">
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
    Alpine.data('messageTabs', () => ({
        tab: 'contact',
        recipientType: '',
        recipientCount: 0,
        tierId: '',
        tierCount: 0,
        startDate: '',
        endDate: '',

        fetchCount(type) {
            let url = '';

            if (type === 'recipient' && this.recipientType) {
                url = `{{ route('admin.messages.templates.count') }}?type=recipient_type&recipient_type=${this.recipientType}`;
            } 
            else if (type === 'tier') {
                const params = new URLSearchParams({
                    type: 'tier',
                    reward_id: this.tierId || '',
                    start_date: this.startDate || '',
                    end_date: this.endDate || ''
                });
                url = `{{ route('admin.messages.templates.count') }}?${params.toString()}`;
            } 
            else return;

            fetch(url)
                .then(res => res.json())
                .then(data => {
                    if (type === 'recipient') this.recipientCount = data.count || 0;
                    if (type === 'tier') this.tierCount = data.count || 0;
                })
                .catch(() => {
                    if (type === 'recipient') this.recipientCount = 0;
                    if (type === 'tier') this.tierCount = 0;
                });
        }
    }));
});

document.addEventListener('DOMContentLoaded', () => {
    const getComponent = () => {
        const el = document.querySelector('#messageTabsRoot');
        return el && el._x_dataStack ? el._x_dataStack[0] : null;
    };

    flatpickr("#start_date", {
        dateFormat: "Y-m-d",
        maxDate: "today",
        onChange: (selectedDates, dateStr) => {
            const component = getComponent();
            if (component) {
                component.startDate = dateStr;
                component.fetchCount('tier');
            }
        }
    });

    flatpickr("#end_date", {
        dateFormat: "Y-m-d",
        maxDate: "today",
        onChange: (selectedDates, dateStr) => {
            const component = getComponent();
            if (component) {
                component.endDate = dateStr;
                component.fetchCount('tier');
            }
        }
    });

    $('#users').select2({
        placeholder: 'Search and select users...',
        ajax: {
            url: '{!! route("admin.users.search") !!}',
            dataType: 'json',
            delay: 300,
            data: params => ({ query: params.term }),
            processResults: data => ({
                results: data.map(user => ({
                    id: user.id,
                    text: `${user.first_name} ${user.last_name} (${user.email || user.phone || 'No contact'})`
                }))
            }),
            cache: true
        },
        minimumInputLength: 2
    }).on('change', function () {
        const count = $(this).val().length;
        const component = getComponent();
        if (component) component.recipientCount = count;
    });
});


</script>
@endpush

