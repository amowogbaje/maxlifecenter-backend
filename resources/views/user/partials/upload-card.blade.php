{{-- User Info --}}
<div class="flex items-center justify-between mb-3 lg:mb-4">
    <div class="flex items-center gap-2 lg:gap-3">
        <img src="{{ $card['user']['avatar'] }}" alt="{{ $card['user']['name'] }}" class="w-7 h-7 lg:w-8 lg:h-8 rounded-full border border-dashboard-white object-cover" />
        <div class="min-w-0 flex-1">
            <div class="text-xs font-bold text-dashboard-text-dark truncate">{{ $card['user']['name'] }}</div>
            <div class="text-xs text-dashboard-text-light truncate">{{ $card['user']['email'] }}</div>
        </div>
        <div class="w-3 h-3 bg-dashboard-yellow rounded flex items-center justify-center flex-shrink-0">
            <i data-lucide="star" class="w-2 h-2 text-white"></i>
        </div>
    </div>
    <div class="w-4 h-4 lg:w-5 lg:h-5 bg-dashboard-light-1 rounded-full flex items-center justify-center flex-shrink-0">
        <i data-lucide="more-vertical" class="w-2.5 h-2.5 text-dashboard-primary"></i>
    </div>
</div>

{{-- Image with Video/Carousel logic --}}
<div class="relative mb-3 lg:mb-4">
    <img src="{{ $card['image'] }}" alt="Upload" class="w-full h-32 lg:h-36 object-cover rounded-lg" />
    @if($card['hasVideo'])
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="w-8 h-8 lg:w-10 lg:h-10 bg-dashboard-yellow rounded-full flex items-center justify-center shadow-lg">
                <i data-lucide="play" class="w-3 h-3 lg:w-4 lg:h-4 text-white ml-0.5"></i>
            </div>
        </div>
    @endif
    @if($card['hasCarousel'])
        <button class="absolute left-2 top-1/2 transform -translate-y-1/2 w-4 h-4 bg-dashboard-yellow rounded-full flex items-center justify-center">
            <i data-lucide="chevron-left" class="w-2.5 h-2.5 text-white"></i>
        </button>
        <button class="absolute right-2 top-1/2 transform -translate-y-1/2 w-4 h-4 bg-dashboard-yellow rounded-full flex items-center justify-center">
            <i data-lucide="chevron-right" class="w-2.5 h-2.5 text-white"></i>
        </button>
    @endif
</div>

{{-- Stats --}}
<div class="flex items-center justify-between mb-2 lg:mb-3 text-xs">
    <div class="text-center">
        <div class="text-dashboard-text-light">Impression</div>
        <div class="font-medium text-dashboard-text-dark">{{ $card['impressions'] }}</div>
    </div>
    <div class="text-center">
        <div class="text-dashboard-text-light">Bonus Points</div>
        <div class="flex items-center gap-1 justify-center">
            <i data-lucide="star" class="w-2 h-2 text-dashboard-yellow"></i>
            <span class="font-medium text-dashboard-text-dark">{{ $card['bonusPoints'] }}</span>
        </div>
    </div>
    <div class="text-center">
        <div class="text-dashboard-text-light">Status</div>
        <span class="status-approved">{{ $card['status'] }}</span>
    </div>
</div>

{{-- Content --}}
<p class="text-xs text-dashboard-dark leading-relaxed line-clamp-3">{{ $card['content'] }}</p>