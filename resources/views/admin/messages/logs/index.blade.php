@extends('admin.layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4">
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-6 gap-4">
        <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Message Audit Logs</h1>

        <!-- Search -->
        <form method="GET" class="flex flex-col sm:flex-row items-start sm:items-center gap-3 w-full lg:w-auto">
            <div class="relative flex-1 sm:w-[350px]">
                <svg xmlns="http://www.w3.org/2000/svg" 
                     class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5" 
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <circle cx="11" cy="11" r="8"/>
                    <path d="m21 21-4.3-4.3"/>
                </svg>
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Search by action or description..." 
                    value="{{ request('search') }}"
                    class="w-full h-12 pl-12 pr-4 bg-white border border-gray-200 rounded-[14px] text-gray-700 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                />
            </div>
            <button 
                type="submit" 
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-[14px] shadow-sm"
            >
                Search
            </button>
        </form>
    </div>

    <!-- Logs List -->
    <div class="space-y-3">
        @forelse($logs as $log)
        <div class="bg-white rounded-[20px] shadow-sm p-5 hover:shadow-md transition">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 w-full">
                    <div>
                        <p class="text-sm text-gray-500">User</p>
                        <p class="font-semibold text-gray-800 truncate">{{ $log->user->name ?? 'System' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Action</p>
                        <p class="font-semibold capitalize text-gray-800">{{ $log->action }}</p>
                    </div>

                    {{-- <div>
                        <p class="text-sm text-gray-500">Model</p>
                        <p class="font-semibold text-gray-800">{{ class_basename($log->model_type) }}</p>
                    </div> --}}

                    <div>
                        <p class="text-sm text-gray-500">Date</p>
                        <p class="font-semibold text-gray-800">{{ $log->created_at->format('Y-m-d H:i') }}</p>
                    </div>
                </div>

                <div class="w-full sm:w-auto">
                    <p class="text-sm text-gray-500">Description</p>
                    <p class="text-gray-700 truncate">{{ $log->description ?? '—' }}</p>
                </div>

                <a href="{{ route('admin.messages.logs.show', $log->id) }}" 
                   class="flex items-center justify-center bg-indigo-50 hover:bg-indigo-100 text-indigo-600 w-10 h-10 rounded-[12px] transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 12H9m0 0l3-3m-3 3l3 3"/>
                    </svg>
                </a>
            </div>
        </div>
        @empty
        <div class="bg-white p-6 rounded-[20px] shadow-sm text-center text-gray-500">
            No audit logs found.
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($logs->hasPages())
    <div class="flex flex-col sm:flex-row justify-between items-center mt-8 gap-4">
        <p class="text-gray-600 text-sm">
            Showing <span class="font-medium">{{ $logs->firstItem() }}</span>–<span class="font-medium">{{ $logs->lastItem() }}</span> of 
            <span class="font-semibold">{{ $logs->total() }}</span>
        </p>

        <div class="flex items-center gap-2">
            @if($logs->onFirstPage())
                <span class="text-gray-300 cursor-not-allowed">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="m15 18-6-6 6-6"/>
                    </svg>
                </span>
            @else
                <a href="{{ $logs->previousPageUrl() }}" class="text-indigo-600 hover:text-indigo-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="m15 18-6-6 6-6"/>
                    </svg>
                </a>
            @endif

            @if($logs->hasMorePages())
                <a href="{{ $logs->nextPageUrl() }}" class="text-indigo-600 hover:text-indigo-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="m9 18 6-6-6-6"/>
                    </svg>
                </a>
            @else
                <span class="text-gray-300 cursor-not-allowed">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="m9 18 6-6-6-6"/>
                    </svg>
                </span>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection
