@extends('user.layouts.app')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Rewards</h1>
            <p class="text-gray-500">Take a look at your reward history</p>
        </div>

    </div>

    <div class="bg-gradient-to-r from-gray-800 to-gray-900 rounded-2xl overflow-hidden flex-1 flex items-center justify-center">
        <img src="{{ asset('images/reward-banner.png') }}" alt="Reward banner" class="w-full h-full object-contain">
    </div>
    <div class="flex flex-col lg:flex-row gap-6 my-5 py-2">
        <section class="bg-white rounded-2xl p-6 flex-1 shadow-sm relative overflow-hidden">
            <header class="flex items-center justify-between mb-6">
                <h2 class="text-gray-900 text-xl font-bold">KOC Discounts</h2>

            </header>

            @if($currentTier)
            <article class="rounded-xl shadow-sm p-5 hover:shadow-md transition h-full bg-gradient-to-r {{ $currentTier['bg_classes'] }}">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-lg font-bold text-gray-800">{{ $currentTier['title'] }}</h3>

                    <span class="text-xs px-3 py-1 rounded-full font-semibold {{ $currentTier['badge_class'] }}">
                        {{ $currentTier['discount_label'] }}
                    </span>
                </div>

                {!! $currentTier['description'] !!}

                
            </article>
            @else
            <div class="p-6 border rounded-xl text-center text-gray-500">
                No tier unlocked yet.
            </div>
            @endif

        </section>
    </div>


    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Left Column: Search + Rewards List -->
        <div class="lg:col-span-2">

            <!-- Search + Filter -->
            <div class="flex flex-col sm:flex-row items-center gap-3 mb-6">
                <div class="flex items-center w-full sm:flex-1 bg-white border rounded-lg px-3 py-2">
                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z" /></svg>
                    <input type="text" placeholder="Search" class="flex-1 outline-none text-gray-600">
                </div>
                <button class="bg-white border rounded-lg px-4 py-2">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1l-7 8v7l-4-2v-5L3 4z" /></svg>
                </button>
            </div>

            <!-- Rewards List -->
            <div class="space-y-4">
                <!-- Reward Item -->
                <!-- Rewards List -->
                @foreach ($rewards as $reward)
                <div class="flex flex-col md:flex-row md:items-center bg-white p-4 rounded-xl shadow-sm mb-4">
                    <!-- Icon -->
                    <div class="flex-shrink-0 mb-3 md:mb-0 md:mr-4">
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center text-2xl">🎁</div>
                    </div>

                    <!-- Left Info -->
                    <div class="flex-1 mb-3 md:mb-0">
                        <p class="text-sm text-gray-400">{{ $reward->code }}</p>
                        <h3 class="text-base font-bold text-gray-900">{{ $reward->title }}</h3>
                        <p class="text-xs text-gray-500">Created {{ $reward->created_at->format('M d, Y') }}</p>
                    </div>

                    <!-- Description -->
                    <div class="flex-1 mb-3 md:mb-0">
                        <p class="font-semibold text-gray-700">Description</p>
                        <p class="text-xs text-gray-500">
                            {{ $reward->description }}
                        </p>
                    </div>

                    <!-- Button -->
                    <div class="md:ml-4">
                        @if ($reward->pivot->status === 'unclaimed')
                        <button type="button" class="claim-btn w-full md:w-auto bg-black text-white text-sm font-semibold px-4 py-2 rounded-lg" data-id="{{ $reward->pivot->id }}">
                            Claim Reward
                        </button>
                        @elseif ($reward->pivot->status === 'pending')
                        <button disabled class="w-full md:w-auto bg-yellow-500 text-white text-sm font-semibold px-4 py-2 rounded-lg opacity-70 cursor-not-allowed">
                            Pending
                        </button>
                        @elseif ($reward->pivot->status === 'claimed')
                        <button disabled class="w-full md:w-auto bg-green-600 text-white text-sm font-semibold px-4 py-2 rounded-lg opacity-70 cursor-not-allowed">
                            Claimed
                        </button>
                        @endif
                    </div>

                </div>
                @endforeach

                @if ($rewards->isEmpty())
                <p class="text-center text-sm text-gray-500">No rewards available yet.</p>
                @endif

            </div>

        </div>

        <!-- Right Column: User Summary -->
        <div>
            <div class="bg-white rounded-3xl border-2 border-dashed border-gray-300 p-6">
                <!-- Profile -->
                <div class="flex justify-center items-center gap-3 mb-6">

                    <div>
                        <div class="flex items-center gap-2">
                            <p class="font-semibold text-gray-900">{{$user->full_name}}</p>
                            {{-- <img src="https://i.pravatar.cc/80?img=5" alt="avatar" class="w-12 h-12 rounded-full"> --}}
                            <div class="w-12 h-12 bg-green-500/20 rounded-full flex items-center justify-center mb-4">
                                <span class="text-2xl font-bold text-success">{{ Str::substr(auth()->user()->first_name, 0, 1) }}</span>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500">{{$user->email}}</p>
                    </div>
                </div>

                <!-- Bonus & Value -->
                <div class="rounded-2xl bg-[#F6FBEF] p-4 mb-6 flex flex-wrap items-center justify-between gap-4">
                    <!-- Bonus Point -->
                    <div class="flex items-center gap-3 flex-1 min-w-[150px]">
                        <img class="w-9 h-9 rounded-full" src="{{asset('images/icons/bonus_cocoa.png')}}" />
                        <div>
                            <p class="text-xs text-gray-600">Bonus Point</p>
                            <p class="font-semibold text-gray-800">{{ $user->bonus_point }}</p>
                        </div>
                    </div>

                    <!-- Divider (hidden on wrap) -->
                    <div class="hidden sm:block h-10 w-px bg-gray-200 rounded"></div>

                    <!-- Value Amount -->
                    <div class="flex items-center gap-3 flex-1 min-w-[150px]">
                        <img class="w-9 h-9 rounded-full" src="{{asset('images/icons/money.png')}}" />
                        <div>
                            <p class="text-xs text-gray-600">Value Amount</p>
                            <p class="font-semibold text-emerald-700">₦{{ number_format($user->total_spent, 2) }}</p>
                        </div>
                    </div>
                </div>


                <!-- Details -->
                <div class="px-4 flex-1">
                    <div class="grid grid-cols-2 gap-x-4 gap-y-3">
                        <!-- Current Tier -->
                        <div>
                            <p class="text-sm text-brand-light-gray mb-1">Current Tier</p>
                            <p class="text-base font-bold text-brand-dark">
                                {{ $user->tier()->title ?? 'No Tier' }}
                            </p>
                        </div>

                        <!-- Next Tier -->
                        <div>
                            <p class="text-sm text-brand-light-gray mb-1">Next Tier</p>
                            <p class="text-base text-brand-dark">
                                {{ $user->progressToNextTier()['next_tier']->title ?? '🎉 Max Tier Achieved' }}
                            </p>
                        </div>

                        <!-- Points Progress -->
                        <div class="col-span-2">
                            <p class="text-sm text-brand-light-gray mb-1">
                                @if ($user->progressToNextTier()['next_tier'])
                                {{ $user->progressToNextTier()['points_remaining'] }} points away from next tier
                                @else
                                You’ve earned all available points 🚀
                                @endif
                            </p>
                            <div class="w-full bg-gray-200 rounded-full h-5 relative overflow-hidden">
                                <div class="bg-blue-500 h-5 rounded-full transition-all duration-500 flex items-center justify-center text-white text-xs font-semibold" style="width: {{ $user->progressToNextTier()['points_progress'] }}%">
                                    {{ $user->progressToNextTier()['points_progress'] }}%
                                </div>
                            </div>
                        </div>

                        <!-- Purchases Progress -->
                        <div class="col-span-2 mt-3">
                            <p class="text-sm text-brand-light-gray mb-1">
                                @if ($user->progressToNextTier()['next_tier'])
                                {{ $user->progressToNextTier()['purchases_remaining'] }} purchases away from next tier
                                @else
                                You’ve unlocked all tiers with your purchases 👑
                                @endif
                            </p>
                            <div class="w-full bg-gray-200 rounded-full h-5 relative overflow-hidden">
                                <div class="bg-green-500 h-5 rounded-full transition-all duration-500 flex items-center justify-center text-white text-xs font-semibold" style="width: {{ $user->progressToNextTier()['purchases_progress'] }}%">
                                    {{ $user->progressToNextTier()['purchases_progress'] }}%
                                </div>
                            </div>
                        </div>


                    </div>
                </div>



            </div>
        </div>

    </div>
</div>

@endsection

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.claim-btn').forEach(button => {
            button.addEventListener('click', function() {
                let rewardId = this.dataset.id;
                let btn = this;

                btn.disabled = true;
                btn.textContent = 'Processing...';

                fetch(`/api/rewards/${rewardId}/claim`, {
                        method: 'POST'
                        , headers: {
                            'Content-Type': 'application/json'
                            , 'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            btn.classList.remove('bg-black');
                            btn.classList.add('bg-yellow-500', 'opacity-70', 'cursor-not-allowed');
                            btn.textContent = 'Pending ';
                        } else {
                            btn.disabled = false;
                            btn.textContent = 'Claim Reward';
                            alert(data.message);
                        }
                    })
                    .catch(err => {
                        btn.disabled = false;
                        btn.textContent = 'Claim Reward';
                        console.error(err);
                        alert('Something went wrong. Try again.');
                    });
            });
        });
    });

</script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    const swiper = new Swiper('.myDiscountsSwiper', {
        slidesPerView: 1
        , spaceBetween: 20
        , loop: true
        , autoplay: {
            delay: 4000
            , disableOnInteraction: false
        , }
        , pagination: {
            el: '.swiper-pagination'
            , clickable: true
        , }
        , navigation: {
            nextEl: '.swiper-button-next'
            , prevEl: '.swiper-button-prev'
        , }
    , });

</script>
@endpush
