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

    <div class="flex flex-col lg:flex-row gap-6 my-5 py-2">

        <!-- KOC Discounts (Swiper-enabled) -->
        <section class="bg-white rounded-2xl p-6 flex-1 shadow-sm relative overflow-hidden">
            <header class="flex items-center justify-between mb-6">
                <h2 class="text-gray-900 text-xl font-bold">KOC Discounts</h2>
                <div class="flex items-center text-blue-500 cursor-pointer hover:text-blue-600 transition">
                    <span class="text-base font-bold mr-1">View all</span>
                    <svg class="w-2 h-3" fill="currentColor" viewBox="0 0 6 10">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.293 0.293C0.653 -0.068 1.221 -0.095 1.613 0.21L5.707 4.293C6.068 4.653 6.095 5.221 5.79 5.613L1.707 9.707C1.317 10.098 0.683 10.098 0.293 9.707C-0.098 9.317 -0.098 8.683 0.293 8.293L3.586 5L0.293 1.707C-0.098 1.317 -0.098 0.683 0.293 0.293Z" />
                    </svg>
                </div>
            </header>

            <!-- Swiper Container -->
            <div class="swiper myDiscountsSwiper">
                <div class="swiper-wrapper">

                    <!-- Eleniyan -->
                    <div class="swiper-slide">
                        <article class="bg-gradient-to-r from-rose-50 to-pink-100 rounded-xl shadow-sm p-5 hover:shadow-md transition h-full">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-lg font-bold text-rose-700">Eleniyan</h3>
                                <span class="text-xs bg-rose-700 text-white px-3 py-1 rounded-full font-semibold">10% OFF</span>
                            </div>
                            <p class="text-gray-700 text-sm mb-2">
                                Begin your royal journey with <strong>10% off</strong> every purchase. Enjoy up to
                                <strong>₦30,000</strong> in royal rewards — your first taste of the kingdom's generosity.
                            </p>
                            <p class="text-xs italic text-rose-700 font-medium">
                                “Start earning your crown — every purchase brings you closer to your next royal rank.”
                            </p>
                        </article>
                    </div>

                    <!-- Oloye -->
                    <div class="swiper-slide">
                        <article class="bg-gradient-to-r from-yellow-50 to-amber-100 rounded-xl shadow-sm p-5 hover:shadow-md transition h-full">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-lg font-bold text-amber-700">Oloye</h3>
                                <span class="text-xs bg-amber-700 text-white px-3 py-1 rounded-full font-semibold">15% OFF</span>
                            </div>
                            <p class="text-gray-700 text-sm mb-2">
                                Rise in the royal ranks and receive <strong>15% off</strong> your orders. Enjoy up to
                                <strong>₦50,000</strong> in exclusive shopping rewards as recognition of your growing status.
                            </p>
                            <p class="text-xs italic text-amber-700 font-medium">
                                “You're no longer just shopping — you're earning your royal privilege.”
                            </p>
                        </article>
                    </div>

                    <!-- Balogun -->
                    <div class="swiper-slide">
                        <article class="bg-gradient-to-r from-indigo-50 to-blue-100 rounded-xl shadow-sm p-5 hover:shadow-md transition h-full">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-lg font-bold text-indigo-700">Balogun</h3>
                                <span class="text-xs bg-indigo-700 text-white px-3 py-1 rounded-full font-semibold">20% OFF</span>
                            </div>
                            <p class="text-gray-700 text-sm mb-2">
                                Command the kingdom's best with <strong>20% off</strong>. Unlock up to
                                <strong>₦150,000</strong> in royal value — reserved for our most loyal warriors of commerce.
                            </p>
                            <p class="text-xs italic text-indigo-700 font-medium">
                                “Your loyalty speaks power — enjoy the prestige you've earned.”
                            </p>
                        </article>
                    </div>

                    <!-- Kabiyesi -->
                    <div class="swiper-slide">
                        <article class="bg-gradient-to-r from-purple-50 to-violet-100 rounded-xl shadow-sm p-5 hover:shadow-md transition h-full">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-lg font-bold text-violet-700">Kabiyesi</h3>
                                <span class="text-xs bg-violet-700 text-white px-3 py-1 rounded-full font-semibold">30% OFF</span>
                            </div>
                            <p class="text-gray-700 text-sm mb-2">
                                Reign at the very top with <strong>30% off</strong> your purchases. Enjoy up to
                                <strong>₦300,000</strong> in royal value — the kingdom's ultimate token of honor.
                            </p>
                            <p class="text-xs italic text-violet-700 font-medium">
                                “This is the throne of loyalty — where true kings and queens belong.”
                            </p>
                        </article>
                    </div>

                </div>

                <!-- Pagination + Navigation -->
                <div class="swiper-pagination mt-4"></div>
                <div class="swiper-button-next text-gray-700"></div>
                <div class="swiper-button-prev text-gray-700"></div>
            </div>
        </section>

        <!-- TIMEX Banner -->
        <div class="bg-gradient-to-r from-gray-800 to-gray-900 rounded-2xl overflow-hidden flex-1 flex items-center justify-center">
            <img src="{{ asset('images/reward-banner.png') }}" alt="TIMEX banner" class="w-full h-full object-contain">
        </div>
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
