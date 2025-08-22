@extends('admin.layouts.app') {{-- Or your master layout file --}}

@section('content')
<main class="p-4 lg:p-8" x-data="dashboard()">
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

    <div class="flex items-center gap-4 lg:gap-6 mb-6 lg:mb-8">
        <div class="flex-1 max-w-xs lg:max-w-md">
            <div class="relative">
                <i data-lucide="search" class="absolute left-4 lg:left-5 top-1/2 transform -translate-y-1/2 text-dashboard-text-dark w-4 h-4"></i>
                <input type="text" placeholder="Search" class="w-full h-10 lg:h-12 pl-12 lg:pl-14 pr-4 rounded-2xl border-0 bg-dashboard-white shadow-sm focus:outline-none focus:ring-2 focus:ring-dashboard-yellow/20 text-dashboard-search text-sm lg:text-base" />
            </div>
        </div>
        <button class="w-10 h-10 lg:w-12 lg:h-12 bg-dashboard-white rounded-2xl shadow-sm flex items-center justify-center hover:shadow-md transition-shadow">
            <i data-lucide="filter" class="text-dashboard-text-dark w-4 h-4"></i>
        </button>
    </div>

    <div>
        <div x-show="activeTab === 'uploads'" style="display: none;" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-3 lg:gap-4">
            @foreach($uploadCards as $card)
                <div class="upload-card relative">
                    @include('dashboard.partials.upload-card', ['card' => $card])
                </div>
            @endforeach
        </div>

        <div x-show="activeTab === 'requests'" style="display: none;" class="data-table shadow-sm">
            @include('dashboard.partials.requests-table', ['tableData' => $tableData])
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