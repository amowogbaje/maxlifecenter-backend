@extends('admin.layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-10 px-4">

    <!-- Header -->
    <div class="flex items-center justify-between mb-10">
        <h1 class="text-3xl font-bold text-gray-800">Message Details</h1>

        <a href="{{ route('admin.messages.logs.index') }}" 
           class="flex items-center gap-2 text-indigo-600 hover:text-indigo-800 font-medium transition">
            <svg xmlns="http://www.w3.org/2000/svg" 
                 class="w-5 h-5" fill="none" viewBox="0 0 24 24" 
                 stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Logs
        </a>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
        <div class="p-8 space-y-6">

            <!-- Subject -->
            <div>
                <h2 class="text-2xl font-semibold text-gray-900 mb-1">
                    {{ $log->new_data['message_subject'] ?? '(No Subject)' }}
                </h2>
                <p class="text-sm text-gray-500">
                    Sent on {{ $log->created_at->format('M d, Y H:i A') }}
                </p>
            </div>

            <!-- Sender Info -->
            <div class="flex items-center gap-4 border-t border-gray-100 pt-5">
                <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-lg">
                    {{ strtoupper(substr($log->admin->name ?? 'S', 0, 1)) }}
                </div>
                <div>
                    <p class="text-gray-900 font-semibold">
                        {{ $log->admin->name ?? 'System' }}
                    </p>
                    <p class="text-sm text-gray-500">
                        {{ $log->admin->email ?? 'system@admin.local' }}
                    </p>
                </div>
            </div>

            <!-- Recipients -->
            @if(!empty($log->new_data['recipients']))
            <div class="border-t border-gray-100 pt-5">
                <p class="text-sm text-gray-500 mb-1">To:</p>
                <p class="text-gray-800 font-medium">
                    {{ implode(', ', $log->new_data['recipients']) }}
                </p>
            </div>
            @endif

            <!-- Send Info -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 border-t border-gray-100 pt-5">
                <div>
                    <p class="text-gray-500 text-sm mb-1">Send Mode</p>
                    <p class="text-gray-900 font-medium">
                        {{ ucfirst($log->new_data['send_mode'] ?? '-') }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm mb-1">Recipient Type</p>
                    <p class="text-gray-900 font-medium">
                        {{ ucfirst($log->new_data['recipient_type'] ?? '-') }}
                    </p>
                </div>
            </div>

            <!-- Message Body -->
            @if(isset($log->new_data['message_body']))
            <div class="border-t border-gray-100 pt-6">
                <p class="text-sm text-gray-500 mb-3">Message Body</p>
                <div class="bg-indigo-50/60 border border-indigo-100 p-6 rounded-xl text-gray-800 leading-relaxed whitespace-pre-line">
                    {!! nl2br(e($log->new_data['message_body'] ?? 'No message content available.')) !!}
                </div>
            </div>
            @endif

            <!-- Filters (Only if Applied) -->
            @php
                $filters = $log->new_data['filters'] ?? [];
                $hasFilters = collect($filters)->filter(fn($v) => !empty($v))->isNotEmpty();
            @endphp

            @if($hasFilters)
            <div class="border-t border-gray-100 pt-6">
                <p class="text-sm text-gray-500 mb-3">Filters Applied</p>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm text-gray-800">
                    <div>
                        <span class="text-gray-500">Reward Level:</span>
                        <span class="font-medium">{{ $filters['reward_level'] ?? '—' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Start Date:</span>
                        <span class="font-medium">{{ $filters['start_date'] ?? '—' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">End Date:</span>
                        <span class="font-medium">{{ $filters['end_date'] ?? '—' }}</span>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection
