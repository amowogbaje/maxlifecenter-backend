@extends('admin.layouts.app')

@section('content')
<div class="p-4 lg:p-[32px] space-y-6 lg:space-y-8">
    <div class="flex flex-col">
        <h1 class="text-xl lg:text-2xl font-bold text-foreground">Hi, {{ auth('admin')->user()->full_name}}</h1>
        <p class="text-sm lg:text-base font-bold">
            <span class="text-muted-foreground">Take a look your overview </span>
            <span class="text-foreground">Today {{ date('M d, Y') }}</span>
        </p>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @foreach($metricCards as $card)
        <div class="bg-white rounded-2xl shadow p-5 relative flex flex-col justify-between hover:shadow-md transition">

            @if($card['hasAvatar'])
            <div class="flex items-center justify-start mb-3">
                <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $card['bgColor'] }}">
                    <img src="{{asset($card['avatarIcon'])}}" alt="Eleniyan Icon" class="w-8 h-8" />
                </div>
            </div>
            @else
            <!-- Icon -->
            <div class="flex items-center justify-start mb-3">
                <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $card['bgColor'] }}">
                    <svg class="w-4 h-4 text-white" viewBox="0 0 12 12" fill="currentColor">
                        <path d="M2.25 1C1.56 1 1 1.56 1 2.25V3.412C1.00027 3.67934 1.07198 3.94175 1.20771 4.17207C1.34344 4.40239 1.53826 4.59225 1.772 4.722L4.648 6.321C4.0456 6.62512 3.56332 7.12345 3.27909 7.73549C2.99486 8.34752 2.92528 9.03751 3.08159 9.69398C3.2379 10.3504 3.61097 10.935 4.14052 11.3533C4.67008 11.7716 5.32518 11.9991 6 11.9991C6.67482 11.9991 7.32992 11.7716 7.85948 11.3533C8.38903 10.935 8.7621 10.3504 8.91841 9.69398C9.07472 9.03751 9.00514 8.34752 8.72091 7.73549C8.43668 7.12345 7.9544 6.62512 7.352 6.321L10.229 4.723C10.4627 4.59304 10.6574 4.40297 10.793 4.17246C10.9285 3.94196 11 3.67941 11 3.412V2.25C11 1.56 10.44 1 9.75 1H2.25ZM5 5.372V2H7V5.372L6 5.928L5 5.372ZM8 9C8 9.53043 7.78929 10.0391 7.41421 10.4142C7.03914 10.7893 6.53043 11 6 11C5.46957 11 4.96086 10.7893 4.58579 10.4142C4.21071 10.0391 4 9.53043 4 9C4 8.46957 4.21071 7.96086 4.58579 7.58579C4.96086 7.21071 5.46957 7 6 7C6.53043 7 7.03914 7.21071 7.41421 7.58579C7.78929 7.96086 8 8.46957 8 9Z" />
                    </svg>
                </div>
            </div>
            @endif

            <!-- Text -->
            <div class="flex-1">
                <p class="text-sm text-gray-500 mb-1 break-words">{{ $card['subtitle'] }}</p>
                <h3 class="text-2xl font-bold text-gray-900 mb-3 break-words">{{ $card['title'] }}</h3>
                @if(isset($card['value']))
                <div class="bg-blue-50 rounded-lg px-3 py-1 inline-block">
                    <span class="text-xs font-semibold text-gray-700 break-words">{{ $card['value'] }}</span>
                </div>
                @endif
            </div>

            <!-- Avatar -->
            
        </div>
        @endforeach
    </div>


    <div class="space-y-4">
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
            <h2 class="text-xl lg:text-2xl font-bold text-foreground">Activity Logs</h2>
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
            @foreach($activityLogs as $log)
            <div class="bg-white rounded-[24px] shadow-sm p-4 lg:p-5 overflow-hidden">
                <div class="flex items-center gap-4 lg:gap-6 min-w-0">
                    <div class="w-[50px] h-[50px] bg-gray-300 rounded-full border-2 border-white relative flex-shrink-0 flex items-center justify-center">
                        <div class="w-9 h-9 bg-success rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" viewBox="0 0 23 22" fill="currentColor">
                                <path d="M15.6899 5.71106C16.0368 5.71106 16.3234 5.95161 16.3688 6.26372L16.375 6.35048V17.9605C16.375 18.3137 16.0683 18.5999 15.6899 18.5999C15.3431 18.5999 15.0565 18.3594 15.0111 18.0473L15.0049 17.9605V6.35048C15.0049 5.99734 15.3116 5.71106 15.6899 5.71106Z" />
                                <path d="M18.9292 14.0172C19.1961 13.7669 19.6299 13.766 19.8981 14.0151C20.1419 14.2416 20.1649 14.5968 19.9665 14.8475L19.9003 14.9194L16.1754 18.412C15.932 18.6403 15.5499 18.6611 15.2813 18.4743L15.2043 18.412L11.4794 14.9194C11.2125 14.6691 11.2135 14.2642 11.4817 14.0151C11.7254 13.7886 12.1061 13.7688 12.3738 13.9551L12.4505 14.0172L15.6895 17.054L18.9292 14.0172Z" />
                                <path d="M6.6207 3.39758C6.96754 3.39758 7.25418 3.63814 7.29955 3.95024L7.3058 4.03701V15.647C7.3058 16.0002 6.99907 16.2865 6.6207 16.2865C6.27387 16.2865 5.98723 16.0459 5.94186 15.7338L5.93561 15.647V4.03701C5.93561 3.68386 6.24234 3.39758 6.6207 3.39758Z" />
                                <path d="M6.13525 3.58542C6.37871 3.35715 6.76076 3.33639 7.02942 3.52317L7.10636 3.58542L10.8313 7.07809C11.0982 7.32838 11.0972 7.73324 10.829 7.98237C10.5852 8.20886 10.2046 8.22867 9.93683 8.04236L9.86014 7.98028L6.6206 4.94251L3.38147 7.98028C3.1388 8.20782 2.75825 8.22927 2.48959 8.04412L2.4126 7.98237C2.16881 7.75589 2.14582 7.4007 2.3442 7.14995L2.41036 7.07809L6.13525 3.58542Z" /></svg>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 gap-4 lg:gap-6">
                            <div class="flex flex-col gap-1 min-w-0">
                                <span class="text-sm text-text-light">User</span>
                                <span class="text-base text-text-dark truncate" title="{{ $log->user->name ?? 'System' }}">{{ $log->user->name ?? 'System' }}</span>
                            </div>
                            <div class="flex flex-col gap-1 min-w-0">
                                <span class="text-sm text-text-light truncate">Action</span>
                                <span class="text-base font-bold text-text-dark truncate" title="{{ $log->action }}">{{ ucfirst(str_replace('_', ' ', $log->action)) }}{{ $log['amount'] }}</span>
                            </div>
                            <div class="flex flex-col gap-1 min-w-0 sm:col-span-2 lg:col-span-1">
                                <span class="text-sm text-text-light">Date</span>
                                <span class="text-xs lg:text-base text-text-dark truncate" title="{{ $log->created_at->format('Y-m-d H:i') }}">{{ $log->created_at->format('Y-m-d H:i') }}</span>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('admin.messages.logs.show', $log->id) }}" class="hidden sm:flex w-9 h-9 lg:w-11 lg:h-11 bg-light-blue rounded-[10px] lg:rounded-[14px] items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-black" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
    @if($activityLogs->hasPages())
    <div class="flex flex-col sm:flex-row justify-between items-center mt-8 gap-4">
        <p class="text-gray-600 text-sm">
            Showing <span class="font-medium">{{ $activityLogs->firstItem() }}</span>–<span class="font-medium">{{ $activityLogs->lastItem() }}</span> of 
            <span class="font-semibold">{{ $activityLogs->total() }}</span>
        </p>

        <div class="flex items-center gap-2">
            @if($activityLogs->onFirstPage())
                <span class="text-gray-300 cursor-not-allowed">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="m15 18-6-6 6-6"/>
                    </svg>
                </span>
            @else
                <a href="{{ $activityLogs->previousPageUrl() }}" class="text-indigo-600 hover:text-indigo-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="m15 18-6-6 6-6"/>
                    </svg>
                </a>
            @endif

            @if($activityLogs->hasMorePages())
                <a href="{{ $activityLogs->nextPageUrl() }}" class="text-indigo-600 hover:text-indigo-800">
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
</div>
@endsection
