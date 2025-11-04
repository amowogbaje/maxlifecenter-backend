@extends('admin.layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4">
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-6 gap-4">
        <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Message Logs</h1>

        <!-- Search -->
        <form method="GET" class="flex flex-col sm:flex-row items-start sm:items-center gap-3 w-full lg:w-auto">
            <div class="relative flex-1 sm:w-[350px]">
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.3-4.3" />
                </svg>
                <input type="text" name="search" placeholder="Search by action or description..." value="{{ request('search') }}" class="w-full h-12 pl-12 pr-4 bg-white border border-gray-200 rounded-[14px] text-gray-700 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
            </div>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-[14px] shadow-sm">
                Search
            </button>
        </form>
    </div>


    <div class="space-y-3">
        @forelse($logs as $log)
        <div class="bg-white hover:bg-indigo-50 transition-all duration-200 rounded-[20px] shadow-sm p-4 flex flex-col sm:flex-row sm:items-center justify-between group cursor-pointer">
            <!-- Left: Sender & Message Info -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 flex-1">
                <!-- Sender Avatar -->
                <div class="flex items-center justify-center w-10 h-10 rounded-full bg-indigo-100 text-indigo-700 font-bold">
                    {{ strtoupper(substr($log->user->full_name ?? 'S', 0, 1)) }}
                </div>

                <!-- Message Summary -->
                <div class="flex-1 min-w-0">
                    <div class="flex justify-between items-center">
                        <p class="font-semibold text-gray-800 truncate">
                            {{ $log->user->full_name ?? 'System' }}
                        </p>
                        <p class="text-xs text-gray-500">
                            {{ $log->created_at->format('M d, Y H:i') }}
                        </p>
                    </div>

                    @if(is_array($log->new_data))
                    <p class="text-sm text-gray-700 mt-1 font-medium truncate">
                        {{ $log->new_data['message_subject'] ?? '(No Subject)' }}
                    </p>

                    <p class="text-sm text-gray-500 truncate">
                        To: {{ implode(', ', $log->new_data['recipients'] ?? []) }}
                    </p>
                    @else
                    <p class="text-sm text-gray-500 italic">Invalid message data</p>
                    @endif
                </div>
            </div>

            <!-- Right: View Button -->
            <a href="{{ route('admin.messages.sent.show', $log->id) }}" class="ml-4 text-indigo-600 hover:text-indigo-800 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </a>
        </div>
        @empty
        <div class="bg-white p-6 rounded-[20px] shadow-sm text-center text-gray-500">
            No message logs found.
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
                    <path d="m15 18-6-6 6-6" />
                </svg>
            </span>
            @else
            <a href="{{ $logs->previousPageUrl() }}" class="text-indigo-600 hover:text-indigo-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="m15 18-6-6 6-6" />
                </svg>
            </a>
            @endif

            @if($logs->hasMorePages())
            <a href="{{ $logs->nextPageUrl() }}" class="text-indigo-600 hover:text-indigo-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="m9 18 6-6-6-6" />
                </svg>
            </a>
            @else
            <span class="text-gray-300 cursor-not-allowed">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="m9 18 6-6-6-6" />
                </svg>
            </span>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection
