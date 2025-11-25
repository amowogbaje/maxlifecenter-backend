@extends('user.layouts.app')
@section('content')
<div class="mb-[32px] px-6">
    <h1 class="text-[#1D1F24] text-2xl font-bold font-nunito mb-[8px]"> {{ $currentTier }}, {{auth('web')->user()->full_name}}</h1>
    <p class="text-base font-nunito">
        <span class="text-[#1D1F24] font-bold">Next Tier: {{ $nextTier }}</span>
        {{-- <span class="text-[#6B6E75] font-bold">Take a look your overview </span> --}}
        {{-- <span class="text-[#1D1F24] font-bold">Today {{ now()->format('M d, Y') }}</span> --}}
    </p>
</div>



{{-- <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mb-12 px-6">

    <!-- Current Tier -->
    <div class="bg-white rounded-2xl shadow p-5 relative flex flex-col justify-between hover:shadow-md transition">
        <!-- Icon -->
        <div class="flex items-center justify-center mb-3">
            <div class="w-9 h-9 bg-green-100 rounded-full flex items-center justify-center">
                <img src="{{ asset('images/'. strtolower($currentTier) .'.png')}}" class="w-7 h-7" alt="{{ $currentTier }}" />
</div>
</div>

<!-- Text -->
<div class="flex-1 text-center">
    <p class="text-xs text-gray-500 mb-1">Current Tier</p>
    <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ $currentTier }}</h3>
</div>
</div>

@if($nextTier)
<!-- Next Tier -->
<div class="bg-white rounded-2xl shadow p-5 relative flex flex-col justify-between hover:shadow-md transition">
    <!-- Icon (3× Bigger) -->
    <div class="flex items-center justify-center mb-3">
        <div class="w-28 h-28 bg-green-100 rounded-full flex items-center justify-center shadow-inner">
            <img src="{{ asset('images/'. strtolower($nextTier) .'.png')}}" class="w-20 h-20" alt="{{ $nextTier }}" />
        </div>
    </div>

    <!-- Text -->
    <div class="flex-1 text-center">
        <p class="text-xs text-gray-500 mb-1">Next Tier</p>
        <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ $nextTier }}</h3>
    </div>
</div>
@endif




</div> --}}

<!-- Bottom Grid -->
<div class="bg-gradient-to-r from-gray-800 to-gray-900 rounded-2xl overflow-hidden flex-1 flex items-center justify-center">
    <img src="{{ asset('images/reward-banner.png') }}" alt="Reward banner" class="w-full h-full object-contain">
</div>

<!-- Active Campaign Section -->
<div class="mt-5 flex flex-col lg:flex-row gap-6">

    <!-- Active Campaign -->
    <div class="bg-white rounded-2xl p-6 flex-1 max-w-full">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-gray-900 text-xl font-bold">Updates</h2>
            <div class="flex items-center text-blue-500 cursor-pointer">

                <a href="{{ route('updates.index') }}" class="flex items-center">
                    <span class="text-base font-bold mr-1">View all</span>
                    <svg class="w-2 h-3" fill="currentColor" viewBox="0 0 6 10">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.293 0.293C0.653 -0.068 1.221 -0.095 1.613 0.21L5.707 4.293C6.068 4.653 6.095 5.221 5.79 5.613L1.707 9.707C1.317 10.098 0.683 10.098 0.293 9.707V1.707C-0.068 1.347 -0.095 0.779 0.21 0.387Z" />
                    </svg>
                </a>

            </div>
        </div>

        <!-- Update Items -->
        <div class="space-y-5">
            @foreach($updates as $key => $update)
            <a href="{{ route('updates.show', $update) }}" class="block">
                <div class="bg-white rounded-xl shadow p-4 flex items-center hover:shadow-lg transition">
                    <div class="w-1 h-10 bg-pink-400 rounded mr-6"></div>

                    <div class="flex-1">
                        <div class="text-gray-900 flex text-xl font-bold mb-2">
                            <svg class="w-6 h-6 me-2 text-pink-400 fill-current" viewBox="0 0 27 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14.2548 2.9636C15.653 1.67814 17.9189 1.67848 19.3163 2.96458C20.505 4.05885 20.6827 5.73188 19.8495 6.99973H21.4511C23.2508 6.9998 24.7097 8.34304 24.7099 9.99973V10.9997C24.7099 12.3056 23.8022 13.4128 22.537 13.8249V18.9997C22.537 20.5974 21.1803 21.9036 19.4697 21.9949L19.2783 21.9997H8.41595C6.68051 21.9997 5.26127 20.7512 5.16205 19.1765L5.15717 18.9997V13.8249C3.89197 13.4128 2.98431 12.3056 2.98431 10.9997V9.99973C2.98447 8.34301 4.44342 6.99975 6.2431 6.99973H7.84467C7.01167 5.73224 7.18923 4.05994 8.37787 2.96555C9.77531 1.6791 12.0407 1.6785 13.4394 2.96458C13.5893 3.10261 13.7251 3.2577 13.8476 3.42942C13.9702 3.25792 14.1048 3.10167 14.2548 2.9636ZM7.32904 18.9997C7.32904 19.5126 7.74878 19.9351 8.289 19.9929L8.41595 19.9997H12.7607V13.9997H7.32904V18.9997ZM14.9335 19.9997H19.2783C19.8352 19.9997 20.2945 19.6141 20.3574 19.1169L20.3652 18.9997V13.9997H14.9335V19.9997ZM6.2431 8.99973C5.64328 8.99975 5.15732 9.44758 5.15717 9.99973V10.9997C5.15717 11.552 5.64319 11.9997 6.2431 11.9997H12.7607V8.99973H6.2431ZM14.9335 11.9997H21.4511C22.051 11.9997 22.537 11.552 22.537 10.9997V9.99973C22.5369 9.44761 22.0509 8.9998 21.4511 8.99973H14.9335V11.9997ZM11.9042 4.37864C11.3545 3.87326 10.4634 3.8739 9.914 4.37962C9.36482 4.88534 9.36456 5.70508 9.91302 6.21067C10.1468 6.42587 10.7262 6.63959 11.5204 6.78587C11.7723 6.83223 12.0363 6.8701 12.3056 6.9011L12.6953 6.94016L12.6533 6.58079L12.5966 6.2136L12.5283 5.85911C12.3694 5.12787 12.1376 4.59355 11.9042 4.37864ZM17.666 4.28489C17.1136 3.87603 16.3035 3.90749 15.791 4.37864C15.5142 4.63342 15.2541 5.3085 15.0976 6.20872C15.0656 6.39279 15.0394 6.57657 15.0175 6.75559L14.996 6.94016L15.3886 6.9011L15.787 6.84934L16.1728 6.78587C16.9673 6.63959 17.5468 6.4255 17.7802 6.21067C18.329 5.70474 18.3292 4.88534 17.7802 4.37962L17.666 4.28489Z" />
                            </svg>
                            <span>{{ $update->title }}</span>
                        </div>

                        <p class="text-gray-500 text-lg leading-4">
                            {{ Str::limit(strip_tags($update->body), 100) }}
                        </p>
                    </div>

                    <div class="flex items-center flex-shrink-0 justify-center gap-x-1">
                        <svg class="w-4 h-4 text-black" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span class="text-gray-500 text-[10px] font-bold">View</span>
                    </div>
                </div>
            </a>
            @endforeach

        </div>
    </div>

    <!-- Products Section -->
    <div class="bg-white rounded-2xl p-6 flex-1 max-w-full">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-[#0A1629] text-xl font-bold font-nunito">Products just for</h2>
            <div class="flex items-center text-[#3F8CFF] cursor-pointer">
                <a href="{{ route('purchases') }}" class="inline-flex items-center text-base font-bold mr-1 text-blue-600 hover:underline">
                    View all
                </a>
                <svg class="w-2 h-3" fill="currentColor" viewBox="0 0 6 10">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.293 0.293C0.653 -0.068 1.221 -0.095 1.613 0.21L5.707 4.293C6.068 4.653 6.095 5.221 5.79 5.613L1.707 9.707C1.317 10.098 0.683 10.098 0.293 9.707V1.707C-0.068 1.347 -0.095 0.779 0.21 0.387Z" />
                </svg>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
            @forelse($recentProducts as $product)
            <a href="{{ $product->url }}" target="_blank" rel="noopener noreferrer" class="block">
            <div class="bg-[#F4F9FD] rounded-xl shadow p-2">
                <!-- Product Image -->
                <div class="w-full h-28 bg-gray-200 rounded-lg mb-3 flex items-center justify-center overflow-hidden">
                    <img class="h-full object-contain" src="{{ $product->image_url ?? asset('/images/placeholder.jpg') }}" alt="{{ $product->name }}" />
                </div>

                <!-- Product Info -->
                <div class="px-2">
                    <p class="text-[#91929E] text-[10px] mb-1 truncate">
                        {{ $product->name }}
                    </p>
                    <p class="text-[#0A1629] text-sm font-bold">
                        ₦{{ number_format($product->price, 2) }}
                    </p>
                </div>
            </div>
            </a>
            @empty
            <div class="col-span-2 sm:col-span-3 text-center text-gray-500 py-6">
                No recent purchases found.
            </div>
            @endforelse
        </div>

    </div>
</div>

<div class="flex flex-col lg:flex-row gap-6">

    <!-- KOC Discounts (Swiper-enabled) -->
    <section class="bg-white rounded-2xl p-6 flex-1 shadow-sm relative overflow-hidden">
        <header class="flex items-center justify-between mb-6">
            <h2 class="text-gray-900 text-xl font-bold">KOC Discounts</h2>

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
            <div class="swiper-button-next flex items-center justify-center">
                <svg class="w-3 h-3 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </div>

            <div class="swiper-button-prev flex items-center justify-center">
                <svg class="w-3 h-3 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </div>
        </div>
    </section>

    <!-- TIMEX Banner -->

</div>
@endsection
@push('script')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<style>
    .swiper-button-next::after,
    .swiper-button-prev::after {
        content: "";
        /* remove built-in arrow */
    }

    .swiper-button-next,
    .swiper-button-prev {
        width: 18px;
        height: 18px;
        color: #6b7280;
        /* gray-500 */
    }

</style>

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
