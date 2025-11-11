@extends('user.layouts.app')
@section('content')

<main class="p-4 lg:px-[50px] lg:py-8 max-w-[1440px]">
    <!-- Title Section -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-8 lg:mb-12">
        <div>
            <h1 class="text-2xl lg:text-[24px] font-bold text-gray-900 mb-1">
                KOC: King of the City
            </h1>
            <p class="text-base lg:text-[16px] font-semibold text-gray-700">
                Where Prestige Meets Privilege
            </p>
        </div>
        <a href={{route('dashboard')}} class="px-3 py-1 rounded-lg bg-blue-50 text-blue-600 text-base font-bold whitespace-nowrap">
            View Your Royal Status
        </a>
    </div>

    <!-- Intro Briefing Section -->
    <section class="mb-10">
        <div class="flex items-center gap-3 mb-[18px]">
            <svg class="w-6 h-6 text-purple-500" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z" />
            </svg>
            <h2 class="text-2xl font-bold text-yellow-500">Intro Briefing</h2>
        </div>
        <div class="p-5 rounded-lg border border-yellow-500 bg-gradient-to-r from-yellow-50 to-yellow-100">
            <p class="text-lg lg:text-xl font-semibold text-gray-900 leading-[1.5]">
                KOC (King of the City) is the premier loyalty program that transcends ordinary
                rewards. This is your exclusive realm, uniting the esteemed families of our
                brother brands. Here, your patronage and influence are celebrated as you embark
                on a noble journey through ascending tiers of prestige. From your first step as a
                promising chief to the pinnacle of Kabiyesi the revered King you will unlock
                unparalleled benefits, exclusive gifts, and the ultimate royal experiences.
            </p>
        </div>
    </section>

    <!-- Royal Family Brands Section -->
    <section class="mb-10">
        <div class="flex items-center gap-3 mb-[18px]">
            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
            </svg>
            <h2 class="text-2xl font-bold text-yellow-500">The Royal Family Brands</h2>
        </div>

        <div class="space-y-[18px]">
            <!-- WatchLocker -->
            <div class="p-5 rounded-lg border border-yellow-500 bg-gradient-to-r from-purple-50 to-orange-100">
                <p class="text-lg lg:text-xl font-semibold text-gray-900 leading-[1.5] mb-[18px]">
                    WatchLocker.ng - A household name for timepieces in Nigeria since 2011,
                    WatchLocker is founded on the belief that "time is the most precious gift." They
                    offer quality time just for you with a curated collection of luxury and premium
                    watches from global brands like Citizen, Casio, and Fossil. They serve customers
                    nationwide through their robust online store and physical locations in Lagos and
                    Abuja
                </p>
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-2">
                    <a href="https://watchlocker.ng" target="_blank" rel="noopener noreferrer" class="text-lg lg:text-xl font-medium italic text-purple-700 hover:underline">
                        https://watchlocker.ng
                    </a>
                    <p class="text-lg lg:text-xl font-semibold text-gray-900">
                        "Time is the most precious gift"
                    </p>
                </div>
            </div>

            <!-- KCLAN -->
            <div class="p-5 rounded-lg border border-blue-500 bg-gradient-to-r from-blue-50 to-purple-100">
                <p class="text-lg lg:text-xl font-semibold text-gray-900 leading-[1.5]">
                    KCLAN is a distinguished fashion brand that celebrates cultural heritage through
                    its contemporary designs. With a physical presence in Lagos and Abuja, KCLAN is
                    an active participant in the cultural fashion scene, creating pieces that connect
                    modern style with rich tradition.
                </p>
            </div>
        </div>
    </section>

    <!-- Hierarchy of Prestige Section -->
    <section>
        <div class="flex items-center gap-3 mb-[18px]">
            <svg class="w-6 h-6 text-indigo-700" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.1501 7.1498H13.0501V9.4498H20.9501C21.2701 9.4498 21.5961 9.5598 21.8431 9.8068C22.0901 10.0538 22.2001 10.3788 22.2001 10.6998V15.3998C22.2001 15.7198 22.0901 16.0458 21.8431 16.2928C21.7252 16.4083 21.5855 16.4993 21.4323 16.5606C21.279 16.6219 21.1151 16.6522 20.9501 16.6498H13.0501V19.2498H15.1501C15.2974 19.2497 15.4416 19.293 15.5645 19.3744C15.6874 19.4557 15.7836 19.5715 15.8411 19.7072C15.8986 19.8429 15.9148 19.9925 15.8878 20.1374C15.8608 20.2823 15.7916 20.416 15.6891 20.5218L12.5891 23.7218C12.5198 23.7934 12.4369 23.8504 12.3454 23.8897C12.2538 23.9289 12.1553 23.9495 12.0557 23.9502C11.9561 23.9509 11.8574 23.9318 11.7652 23.894C11.6731 23.8562 11.5894 23.8003 11.5191 23.7298L8.31906 20.5298C8.21424 20.4249 8.1429 20.2912 8.11405 20.1457C8.08519 20.0002 8.10013 19.8494 8.15696 19.7124C8.2138 19.5754 8.30998 19.4583 8.43335 19.376C8.55672 19.2937 8.70173 19.2497 8.85006 19.2498H11.0501V16.6498H3.05006C2.73006 16.6498 2.40406 16.5398 2.15706 16.2928C2.04154 16.1749 1.95052 16.0353 1.88924 15.882C1.82797 15.7287 1.79766 15.5649 1.80006 15.3998V10.6998C1.80006 10.3798 1.91006 10.0538 2.15706 9.8068C2.40406 9.5598 2.73006 9.4498 3.05006 9.4498H11.0501V7.1498H7.95006C5.92006 7.1498 4.40006 5.4968 4.40006 3.5998C4.40006 1.5678 6.05306 0.0498047 7.95006 0.0498047H16.1501C18.1821 0.0498047 19.7001 1.7028 19.7001 3.5998C19.7001 5.5138 18.0641 7.1498 16.1501 7.1498Z" />
            </svg>
            <h2 class="text-2xl font-bold text-yellow-500">
                The Hierarchy of Prestige & rewards
            </h2>
        </div>

        <div class="space-y-3">
            @foreach ($tiers as $tier)
            <div class="p-5 pr-[52px] rounded-lg border {{ $tier['border'] }} bg-gradient-to-r {{ $tier['gradient'] }} flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-{{ $tier['color'] }}-600 mb-[6px]">
                        {{ $tier['name'] }}
                    </h3>
                    <p class="text-lg font-semibold text-gray-900 whitespace-pre-line">
                        @foreach ($tier['benefits'] as $benefit)
                        • {{ $benefit }}<br>
                        @endforeach
                    </p>
                </div>
                <div class="w-[{{ $tier['size']['w'] }}px] h-[{{ $tier['size']['h'] }}px] rounded-full bg-gray-100 flex items-center justify-center flex-shrink-0">
                    <img src="{{ $tier['image'] }}" alt="{{ $tier['name'] }}" class="w-[{{ $tier['size']['img'] }}px] h-[{{ $tier['size']['img'] }}px]" />
                </div>
            </div>
            @endforeach
        </div>

    </section>
</main>
@endsection
