@extends('admin.layouts.app') {{-- Or your master layout file --}}

@section('content')
<main class="p-4 lg:p-8">
    <div class="mb-6 lg:mb-8">
        {{-- You can get the authenticated user's name dynamically --}}
        <h1 class="text-xl lg:text-2xl font-bold text-dashboard-dark mb-2">Hi, {{ Auth::user()->name ?? 'Kemi Wale' }}</h1>
        <p class="text-sm lg:text-base text-dashboard-dark-2 font-bold">
            Take a look your overview <span class="text-dashboard-dark" x-text="`Today ${todayDate}`"></span>
        </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-6 lg:mb-8">
        @foreach($statsData as $stat)
            <div class="dashboard-card p-4 lg:p-6">
                <div class="flex items-start justify-between mb-3 lg:mb-4">
                    <div class="w-6 h-6 lg:w-7 lg:h-7 rounded-full flex items-center justify-center {{ $stat['bgColor'] }}">
                        <i data-lucide="star" class="text-white w-2.5 h-2.5"></i>
                    </div>
                </div>
                <div class="space-y-1">
                    <p class="text-xs text-dashboard-text-light">{{ $stat['title'] }}</p>
                    <p class="text-xl lg:text-2xl font-bold text-dashboard-text-dark">{{ $stat['value'] }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mb-6 lg:mb-8 overflow-x-auto">
        <div class="bg-dashboard-light-1 rounded-3xl p-2 inline-flex min-w-max">
            <button @click="activeTab = 'uploads'" :class="activeTab === 'uploads' ? 'bg-dashboard-yellow text-dashboard-white' : 'text-dashboard-text-dark hover:bg-dashboard-white/50'" class="px-4 lg:px-8 py-2 lg:py-3 rounded-2xl font-bold text-sm lg:text-base transition-all whitespace-nowrap">
                Uploads
            </button>
            <button @click="activeTab = 'requests'" :class="activeTab === 'requests' ? 'bg-dashboard-yellow text-dashboard-white' : 'text-dashboard-text-dark hover:bg-dashboard-white/50'" class="px-4 lg:px-8 py-2 lg:py-3 rounded-2xl font-bold text-sm lg:text-base transition-all whitespace-nowrap">
                User Upload Request
            </button>
        </div>
    </div>

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

    <div>
        <div x-show="activeTab === 'uploads'" style="display: none;" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-3 lg:gap-4">
            @foreach($uploadCards as $card)
                <div class="upload-card relative">
                    @include('admin.partials.upload-card', ['card' => $card])
                </div>
            @endforeach
        </div>

        <div x-show="activeTab === 'requests'" style="display: none;" class="data-table shadow-sm">
            @include('admin.partials.requests-table', ['tableData' => $tableData])
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    function dashboard() {
        return {
            activeTab: 'uploads', // Default active tab
            todayDate: '',
            init() {
                // Get and format today's date for the welcome message
                const today = new Date();
                this.todayDate = today.toLocaleDateString('en-US', {
                    month: 'long',
                    day: 'numeric',
                    year: 'numeric'
                });
                // Initialize Lucide icons after Alpine.js is ready
                this.$nextTick(() => {
                    lucide.createIcons();
                });
            }
        }
    }
</script>
@endpush