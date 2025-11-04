@extends('admin.layouts.app')

@section('title', 'Audit Log Details')

@section('content')
<div class="max-w-5xl mx-auto bg-white rounded-2xl shadow-lg p-8 mt-10 space-y-8">

    {{-- Header --}}
    <div class="flex justify-between items-center border-b pb-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">🧾 Audit Log Details</h1>
            <p class="text-gray-500 text-sm mt-1">
                Logged {{ $log->created_at->diffForHumans() }}
                ({{ $log->created_at->format('M d, Y h:i A') }})
            </p>
        </div>

        <a href="{{ url()->previous() }}" 
           class="bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm px-4 py-2 rounded-lg shadow-sm transition">
           ← Back
        </a>
    </div>

    {{-- Log Overview --}}
    <section class="space-y-2">
        <h2 class="text-lg font-semibold text-gray-700 mb-2">Overview</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
            <div><strong>Action:</strong> {{ ucfirst(str_replace('_', ' ', $log->action)) }}</div>
            {{-- <div><strong>Model Type:</strong> {{ class_basename($log->model_type) }}</div> --}}
            {{-- <div><strong>Model ID:</strong> {{ $log->model_id }}</div> --}}
            <div><strong>Performed By:</strong> {{ $log->user->full_name ?? 'System' }}</div>
            <div><strong>User Email:</strong> {{ $log->user->email ?? '—' }}</div>
            <div><strong>Description:</strong> {{ $log->description ?? 'No description provided.' }}</div>
        </div>
    </section>

    {{-- Change Summary --}}
    @if($log->old_data || $log->new_data)
    <section class="space-y-4">
        <h2 class="text-lg font-semibold text-gray-700">Data Changes</h2>

        {{-- Old Data --}}
        @if($log->old_data)
        <div class="bg-red-50 border border-red-100 rounded-xl p-4">
            <h3 class="font-semibold text-red-700 mb-2">🔴 Old Data</h3>
            <pre class="text-xs text-gray-700 overflow-auto whitespace-pre-wrap">{{ json_encode($log->old_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
        </div>
        @endif

        {{-- New Data --}}
        @if($log->new_data)
        <div class="bg-green-50 border border-green-100 rounded-xl p-4">
            <h3 class="font-semibold text-green-700 mb-2">🟢 New Data</h3>
            <pre class="text-xs text-gray-700 overflow-auto whitespace-pre-wrap">{{ json_encode($log->new_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
        </div>
        @endif
    </section>
    @else
        <p class="text-gray-500 italic">No data changes recorded for this log.</p>
    @endif

    {{-- Metadata --}}
    <section class="border-t pt-4 text-sm text-gray-600 space-y-1">
        <p><strong>Log ID:</strong> {{ $log->id }}</p>
        <p><strong>Created At:</strong> {{ $log->created_at->format('M d, Y h:i A') }}</p>
        <p><strong>Last Updated:</strong> {{ $log->updated_at->format('M d, Y h:i A') }}</p>
    </section>

</div>
@endsection
