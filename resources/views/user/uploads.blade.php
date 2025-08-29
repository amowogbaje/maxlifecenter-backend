@extends('user.layouts.app') {{-- Or your master layout file --}}

@section('content')
<main class="p-4 lg:p-8">
    <div class="mb-6 lg:mb-8">
        {{-- You can get the authenticated user's name dynamically --}}
        <h1 class="text-xl lg:text-2xl font-bold text-foreground">All Uploads</h1>
        <p class="text-sm lg:text-base font-bold">
            <span class="text-muted-foreground">Take a look your uploads </span>
            <span class="text-foreground">Today {{ date('M d, Y') }}</span>
        </p>
    </div>




    <div class="flex justify-between items-center gap-4 w-full lg:w-auto">
        <div class="relative my-3 flex lg:w-[412px]">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-5 top-1/2 transform -translate-y-1/2 w-5 h-5 text-text-dark">
                <circle cx="11" cy="11" r="8" />
                <path d="m21 21-4.3-4.3" />
            </svg>
            <input type="text" placeholder="Search" class="w-full h-12 pl-14 pr-4 bg-white rounded-[14px] shadow-sm border-0 text-text-gray" />
        </div>
        <!-- Filter Dropdown -->
        <div class="flex gap-x-4">
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

            <a href="http://koc.test/purchases" class="w-full flex items-center gap-6 px-6 py-3 rounded-[14px] text-left transition-colors  bg-black text-white shadow-[0_6px_12px_rgba(253,199,72,0.29)]">
                <div class="w-6 h-6 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <span class="font-bold text-base truncate">Add new Upload</span>
            </a>
        </div>

    </div>

    <div>
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-3 lg:gap-4">
            @foreach($uploadCards as $card)
            <div class="upload-card relative bg-white rounded-3xl p-4 lg:p-6">
                @include('user.partials.upload-card', ['card' => $card])
            </div>
            @endforeach
        </div>
    </div>
</main>
@endsection

@push('scripts')

@endpush
