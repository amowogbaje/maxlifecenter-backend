@extends('user.layouts.app')

@section('content')
<div class="p-4 lg:p-[32px] space-y-6 lg:space-y-8">
    <div class="flex flex-col">
        <h1 class="text-xl lg:text-2xl font-bold text-foreground">Purchase History</h1>
        <p class="text-sm lg:text-base font-bold">
            <span class="text-muted-foreground">Take a look your purchase history</span>
        </p>
    </div>


    <div class="space-y-4">
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
            <div class="flex items-center gap-4 w-full lg:w-auto">
                <div class="relative flex-1 lg:w-[412px]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-5 top-1/2 transform -translate-y-1/2 w-5 h-5 text-text-dark">
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.3-4.3" /></svg>
                    <input type="text" placeholder="Search" class="w-full h-12 pl-14 pr-4 bg-white rounded-[14px] shadow-sm border-0 text-text-gray" />
                </div>
                <!-- Filter Dropdown -->
                <div x-data="{ open: false }" class="relative inline-block text-left">
                    <!-- Filter Button -->
                    <button @click="open = !open" class="w-12 h-12 bg-white rounded-[14px] shadow-sm flex items-center justify-center 
               hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 transition" aria-label="Open filters">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                        </svg>
                    </button>

                    <!-- Dropdown Panel -->
                    <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-56 bg-white border border-gray-200 rounded-lg shadow-lg z-50">
                        <div class="p-4 space-y-3">
                            <h3 class="text-sm font-semibold text-gray-700">Filters</h3>

                            <!-- Category Filter -->
                            <label class="block">
                                <span class="text-xs text-gray-500">Category</span>
                                <select class="w-full mt-1 border rounded-md p-2 text-sm">
                                    <option>All</option>
                                    <option>Active</option>
                                    <option>Completed</option>
                                </select>
                            </label>

                            <!-- Date Filter -->
                            <label class="block">
                                <span class="text-xs text-gray-500">Date</span>
                                <input type="date" class="w-full mt-1 border rounded-md p-2 text-sm" />
                            </label>

                            <!-- Actions -->
                            <div class="flex justify-end space-x-2 pt-2">
                                <button @click="open = false" class="text-xs text-gray-600 hover:text-gray-900">Reset</button>
                                <button class="px-3 py-1 bg-blue-600 text-white text-xs rounded-md hover:bg-blue-700">Apply</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="space-y-3">
            @foreach($purchases as $purchase)
            <div class="bg-white rounded-[24px] shadow-sm p-3 sm:p-4 lg:p-5 overflow-hidden">
                <div class="flex items-start gap-3 lg:gap-6 min-w-0">

                    <!-- Icon -->
                    <div class="w-10 h-10 sm:w-[50px] sm:h-[50px] bg-gray-300 rounded-full flex items-center justify-center flex-shrink-0">
                        <div class="w-7 h-7 sm:w-9 sm:h-9 bg-success rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" viewBox="0 0 23 22" fill="currentColor">
                                <path d="M15.6899 5.71106..." />
                            </svg>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-2 sm:gap-4 lg:gap-6">

                            <div class="flex flex-col min-w-0">
                                <span class="text-[11px] sm:text-sm text-text-light">Purchase ID</span>
                                <span class="text-xs sm:text-base text-text-dark truncate" title="{{ $purchase['id'] }}">{{ $purchase['id'] }}</span>
                            </div>

                            <div class="flex flex-col min-w-0">
                                <span class="text-[11px] sm:text-sm text-text-light">Amount</span>
                                <span class="text-xs sm:text-base font-bold text-text-dark truncate" title="{{ $purchase['amount'] }}">{{ $purchase['amount'] }}</span>
                            </div>

                            <div class="flex flex-col min-w-0">
                                <span class="text-[11px] sm:text-sm text-text-light">Date</span>
                                <span class="text-[10px] sm:text-xs lg:text-base text-text-dark truncate" title="{{ $purchase['date'] }}">{{ $purchase['date'] }}</span>
                            </div>

                            <div class="flex flex-col min-w-0">
                                <span class="text-[11px] sm:text-sm text-text-light">Points</span>
                                <span class="text-xs sm:text-base font-bold text-text-dark truncate">
                                    <img src="{{ asset('images/icons/diamond.svg') }}" alt="Bonus Points" class="inline-block w-3 h-3 sm:w-4 sm:h-4 mr-1">
                                    {{ $purchase['bonus_points'] }}
                                </span>
                            </div>

                            @if(!empty($purchase['status']))
                            <div class="flex flex-col min-w-0 col-span-2 sm:col-span-1">
                                <span class="text-[11px] sm:text-sm text-text-light">Status</span>
                                <div class="rounded-md px-2 py-[2px] sm:px-3 sm:py-1 w-fit {{ $purchase['statusColor'] }}">
                                    <span class="text-[10px] sm:text-xs font-bold text-white truncate block">{{ $purchase['status'] }}</span>
                                </div>
                            </div>
                            @endif

                        </div>
                    </div>

                    <!-- Action -->
                    <div class="hidden sm:flex w-9 h-9 lg:w-11 lg:h-11 bg-light-blue rounded-[10px] lg:rounded-[14px] items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" sm:width="20" sm:height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="1" />
                            <circle cx="12" cy="5" r="1" />
                            <circle cx="12" cy="19" r="1" />
                        </svg>
                    </div>
                </div>
            </div>
            @endforeach

        </div>

        <div class="flex justify-center lg:justify-end">
            <div class="bg-white rounded-[14px] shadow-sm px-5 py-3 flex items-center gap-4">
                <span class="text-base text-text-dark">1-8 of 28</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-gray-400">
                    <path d="m15 18-6-6 6-6" /></svg>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-blue-500">
                    <path d="m9 18 6-6-6-6" /></svg>
            </div>
        </div>
    </div>
</div>
@endsection
