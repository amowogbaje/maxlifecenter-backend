@extends('layouts.admin')

@section('title', 'View Contact List')

@section('content')
<div class="max-w-6xl mx-auto bg-white shadow-lg rounded-2xl p-8 mt-10 space-y-10">

    {{-- Header --}}
    <div class="flex justify-between items-center border-b pb-5">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">{{ $contactList->title }}</h1>
            <p class="text-gray-500 text-sm">Created on {{ $contactList->created_at->format('M d, Y') }}</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.messages.contacts.edit', $contactList->id) }}"
               class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-sm text-sm">✏️ Edit</a>
            <a href="{{ route('admin.messages.contacts.index') }}"
               class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg shadow-sm text-sm">← Back</a>
        </div>
    </div>

    {{-- Description --}}
    <section>
        <h2 class="text-lg font-semibold text-gray-700 mb-2">Description</h2>
        <p class="text-gray-600">{{ $contactList->description ?: 'No description provided.' }}</p>
    </section>

    {{-- Users --}}
    <section>
        <h2 class="text-lg font-semibold text-gray-700 mb-3">Users in Contact List</h2>

        @php
            $users = \App\Models\User::whereIn('id', $contactList->user_ids ?? [])->get();
        @endphp

        @if($users->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($users as $user)
                    <div class="border rounded-xl p-4 flex items-center gap-3 hover:shadow-md transition">
                        <img src="{{ $user->profile_photo_url ?? asset('images/default-avatar.png') }}"
                             alt="{{ $user->name }}"
                             class="w-10 h-10 rounded-full object-cover">
                        <div>
                            <p class="font-semibold text-gray-800">{{ $user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $user->email }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 italic">No users in this contact list.</p>
        @endif
    </section>

    {{-- Audit Logs --}}
    <section>
        <h2 class="text-lg font-semibold text-gray-700 mb-3 flex items-center gap-2">
            🧾 Audit History
        </h2>

        @php
            $logs = \App\Models\AuditLog::where('model_type', \App\Models\MessageContact::class)
                ->where('model_id', $contactList->id)
                ->latest()
                ->take(10)
                ->get();
        @endphp

        @if($logs->isNotEmpty())
            <div class="space-y-4">
                @foreach($logs as $log)
                    <div class="p-4 bg-gray-50 rounded-lg border">
                        <div class="flex justify-between">
                            <p class="font-medium text-gray-800">
                                {{ ucfirst(str_replace('_', ' ', $log->action)) }}
                            </p>
                            <span class="text-xs text-gray-500">
                                {{ $log->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 mt-1">
                            {{ $log->description ?? 'No description' }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">
                            By: {{ optional($log->user)->name ?? 'System' }}
                        </p>

                        {{-- Show changed data --}}
                        @if($log->old_data || $log->new_data)
                            <details class="mt-2 bg-white border rounded p-2 text-xs text-gray-600">
                                <summary class="cursor-pointer text-blue-600 font-medium">View Data Changes</summary>
                                <div class="mt-2 space-y-2">
                                    @if($log->old_data)
                                        <pre class="bg-red-50 p-2 rounded overflow-auto"><strong>Old:</strong> {{ json_encode($log->old_data, JSON_PRETTY_PRINT) }}</pre>
                                    @endif
                                    @if($log->new_data)
                                        <pre class="bg-green-50 p-2 rounded overflow-auto"><strong>New:</strong> {{ json_encode($log->new_data, JSON_PRETTY_PRINT) }}</pre>
                                    @endif
                                </div>
                            </details>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 italic">No recent changes logged for this contact list.</p>
        @endif
    </section>

    {{-- Footer --}}
    <footer class="text-sm text-gray-500 border-t pt-4">
        Last updated {{ $contactList->updated_at->diffForHumans() }}
    </footer>
</div>
@endsection
