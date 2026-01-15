@extends('admin.layouts.app')

@section('content')
<div class="flex-1 px-10 py-8 overflow-y-auto">

    <!-- Page Header -->
    <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between mb-8 gap-4">
        <!-- Page Title -->
        <h1 class="text-[#1D1F24] text-2xl font-bold">Update Management</h1>

        <!-- Search Form -->
        <form method="GET" class="flex flex-col sm:flex-row items-start sm:items-center gap-3 w-full lg:w-auto flex-1">
            <div class="relative flex-1 sm:w-[350px]">
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.3-4.3" />
                </svg>
                <input type="text" name="search" placeholder="Search by action or description..." value="{{ request('search') }}" class="w-full h-12 pl-12 pr-4 bg-white border border-gray-200 rounded-[14px] text-gray-700 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
            </div>
        </form>

        <!-- Create New Update Button -->
        <a href="{{ route('admin.updates.create') }}" class="flex items-center gap-3 h-12 px-4 rounded-[14px] bg-blue-500 text-white shadow-[0_6px_12px_0_rgba(63,140,255,0.26)] hover:bg-blue-600 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            <span class="text-base font-bold">Create New Update</span>
        </a>
    </div>


    <!-- Tabs -->
    <input type="hidden" name="status" value="{{ request('status') }}">
    <div class="bg-gray-100 rounded-[24px] h-12 p-1 flex items-center gap-2 mb-8 max-w-[672px]">
        <a href="{{ route('admin.updates.index', array_merge(request()->except('page'), ['status' => null])) }}" class="flex-1 py-2 h-10 rounded-[20px] text-base font-bold text-center transition-all
          {{ request('status') === null ? 'bg-yellow-400 text-white' : 'text-[#0A1629] hover:bg-white/50' }}">
            All
        </a>

        <a href="{{ route('admin.updates.index', array_merge(request()->except('page'), ['status' => 'published'])) }}" class="flex-1 py-2  h-10 rounded-[20px] text-base font-bold text-center transition-all
          {{ request('status') === 'published' ? 'bg-yellow-400 text-white' : 'text-[#0A1629] hover:bg-white/50' }}">
            Published
        </a>

        <a href="{{ route('admin.updates.index', array_merge(request()->except('page'), ['status' => 'draft'])) }}" class="flex-1 py-2 h-10 rounded-[20px] text-base font-bold text-center transition-all
          {{ request('status') === 'draft' ? 'bg-yellow-400 text-white' : 'text-[#0A1629] hover:bg-white/50' }}">
            Draft
        </a>

    </div>

    <!-- Updates Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-[1023px]">
        @forelse ($updates as $update)
        <div class="bg-white rounded-xl p-4 flex flex-col gap-3 hover:shadow-lg transition-shadow">
            @if ($update->image)
            <img src="{{ $update->image }}" alt="" class="w-full h-[147px] object-cover rounded-[6.5px]" />
            @endif

            <div class="flex flex-col gap-[14px]">
                <div class="flex flex-col gap-[9px]">
                    <div class="flex items-start justify-between gap-[18px]">
                        <h3 class="flex-1 text-[#1D1F24] text-lg font-bold">{{ $update->title }}</h3>
                        <a href="{{ route('admin.updates.edit', $update) }}" class="hidden sm:flex w-9 h-9 lg:w-11 lg:h-11 bg-light-blue rounded-[10px] lg:rounded-[14px] items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-black" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                    </div>
                    <p class="text-[#1D1F24] text-sm leading-normal line-clamp-3">
                        {!! $update->excerpt !!}
                    </p>
                </div>

                <div class="flex justify-end">
                    <span class="inline-flex items-center justify-center h-5 px-[10px] rounded text-white text-[9px] font-bold leading-[5.574px]
                            {{ $update->status === 'published' ? 'bg-green-500' : 'bg-blue-500' }}">
                        {{ ucfirst($update->status) }}
                    </span>
                </div>
            </div>
        </div>
        @empty
        <p class="text-gray-500 text-sm col-span-full text-center">No updates found.</p>
        @endforelse
    </div>

    <!-- Pagination -->
    @if ($updates->hasPages())
    <div class="flex flex-col sm:flex-row justify-between items-center mt-8 gap-4">
        <p class="text-gray-600 text-sm">
            Showing <span class="font-medium">{{ $updates->firstItem() }}</span>–<span class="font-medium">{{ $updates->lastItem() }}</span> of
            <span class="font-semibold">{{ $updates->total() }}</span>
        </p>

        <div class="flex items-center gap-2">
            {{-- Previous --}}
            @if ($updates->onFirstPage())
            <span class="text-gray-300 cursor-not-allowed">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="m15 18-6-6 6-6" />
                </svg>
            </span>
            @else
            <a href="{{ $updates->previousPageUrl() }}" class="text-indigo-600 hover:text-indigo-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="m15 18-6-6 6-6" />
                </svg>
            </a>
            @endif

            {{-- Next --}}
            @if ($updates->hasMorePages())
            <a href="{{ $updates->nextPageUrl() }}" class="text-indigo-600 hover:text-indigo-800">
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
