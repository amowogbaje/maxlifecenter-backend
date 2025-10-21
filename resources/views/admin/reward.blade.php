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

            <!-- Icon -->
            <div class="flex items-center justify-start mb-3">
                <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $card['bgColor'] }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 23 20" class="w-4 h-4 fill-current text-white">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.68539 5.34736L5.34041 12.5194C5.38821 13.0714 5.87812 13.4854 6.47665 13.4854H6.481H18.3333H18.3355C18.9015 13.4854 19.3849 13.0974 19.4652 12.5824L20.4972 6.02336C20.5211 5.86736 20.4787 5.71136 20.3755 5.58536C20.2734 5.45836 20.1235 5.37636 19.9541 5.35436C19.727 5.36236 10.3058 5.35036 4.68539 5.34736ZM6.47448 14.9854C5.04386 14.9854 3.83266 13.9574 3.71643 12.6424L2.7214 1.74836L1.08439 1.48836C0.640099 1.41636 0.343546 1.02936 0.419585 0.620365C0.497797 0.211365 0.926875 -0.054635 1.36139 0.00936497L3.62084 0.369365C3.98474 0.428365 4.26174 0.706365 4.29324 1.04636L4.54851 3.84736C20.0562 3.85336 20.1061 3.86036 20.1811 3.86836C20.7861 3.94936 21.3184 4.24036 21.6812 4.68836C22.0441 5.13536 22.1961 5.68636 22.1092 6.23836L21.0784 12.7964C20.8839 14.0444 19.7064 14.9854 18.3377 14.9854H18.3323H6.48317H6.47448Z" />
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M16.5908 9.0437H13.5797C13.1289 9.0437 12.765 8.7077 12.765 8.2937C12.765 7.8797 13.1289 7.5437 13.5797 7.5437H16.5908C17.0406 7.5437 17.4056 7.8797 17.4056 8.2937C17.4056 8.7077 17.0406 9.0437 16.5908 9.0437Z" />
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M6.00717 17.7019C6.33413 17.7019 6.5981 17.9449 6.5981 18.2459C6.5981 18.5469 6.33413 18.7909 6.00717 18.7909C5.67911 18.7909 5.41515 18.5469 5.41515 18.2459C5.41515 17.9449 5.67911 17.7019 6.00717 17.7019Z" />
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M6.00608 18.0408C5.88333 18.0408 5.78339 18.1328 5.78339 18.2458C5.78339 18.4728 6.22985 18.4728 6.22985 18.2458C6.22985 18.1328 6.12883 18.0408 6.00608 18.0408ZM6.00608 19.5408C5.23048 19.5408 4.60044 18.9598 4.60044 18.2458C4.60044 17.5318 5.23048 16.9518 6.00608 16.9518C6.78168 16.9518 7.4128 17.5318 7.4128 18.2458C7.4128 18.9598 6.78168 19.5408 6.00608 19.5408Z" />
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M18.2607 17.7019C18.5876 17.7019 18.8527 17.9449 18.8527 18.2459C18.8527 18.5469 18.5876 18.7909 18.2607 18.7909C17.9326 18.7909 17.6686 18.5469 17.6686 18.2459C17.6686 17.9449 17.9326 17.7019 18.2607 17.7019Z" />
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M18.2596 18.0408C18.1379 18.0408 18.038 18.1328 18.038 18.2458C18.0391 18.4748 18.4844 18.4728 18.4834 18.2458C18.4834 18.1328 18.3823 18.0408 18.2596 18.0408ZM18.2596 19.5408C17.484 19.5408 16.8539 18.9598 16.8539 18.2458C16.8539 17.5318 17.484 16.9518 18.2596 16.9518C19.0363 16.9518 19.6674 17.5318 19.6674 18.2458C19.6674 18.9598 19.0363 19.5408 18.2596 19.5408Z" />
                    </svg>
                </div>
            </div>

            <!-- Text -->
            <div class="flex-1">
                <p class="text-sm text-gray-500 mb-1 break-words">{{ $card['subtitle'] }}</p>
                <h3 class="text-2xl font-bold text-gray-900 mb-3 break-words">{{ $card['title'] }}</h3>
            </div>

        </div>
        @endforeach
    </div>


    <div class="space-y-4">
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
            <h2 class="text-xl lg:text-2xl font-bold text-foreground">Rewards History</h2>
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
            @foreach($userRewards as $userReward)
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
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-4 lg:gap-6">
                            <div class="flex flex-col gap-1 min-w-0">
                                <span class="text-sm text-text-light">Type</span>
                                <span class="text-base text-text-dark truncate" title="{{ $userReward->reward->title }}"><img src="{{ asset('images/icons/diamond.svg') }}" alt="Rewards" class="inline-block w-4 h-4 mr-1">{{ $userReward->reward->title }}</span>
                            </div>
                            <div class="flex flex-col gap-1 min-w-0">
                                <span class="text-sm text-text-light truncate">Name</span>
                                <span class="text-base font-bold text-text-dark truncate" title="{{ $userReward->user->full_name }}">{{ $userReward->user->full_name }}</span>
                            </div>
                            <div class="flex flex-col gap-1 min-w-0 sm:col-span-2 lg:col-span-1">
                                <span class="text-sm text-text-light">Date</span>
                                <span class="text-xs lg:text-base text-text-dark truncate" title="{{ $userReward->updated_at }}">{{ \Carbon\Carbon::parse($userReward->updated_at)->format('M d, Y H:i a') }}</span>
                            </div>
                            <div class="flex flex-col gap-1 min-w-0">
                                <span class="text-sm text-text-light truncate">
                                    Reward perks
                                </span>
                                <span class="text-base text-text-dark truncate" title="{{ $userReward->reward->reward_benefit }}">{{ $userReward->reward->reward_benefit }}</span>
                            </div>
                            {{-- <div class="flex flex-col gap-1 min-w-0">
                                <span class="text-sm text-text-light truncate">
                                    Reward perks
                                </span>
                                <span class="text-base text-text-dark truncate" title="{{ $userReward->reward->reward_benefit }}">{{ $userReward->reward->reward_benefit }}</span>
                            </div> --}}
                        </div>
                    </div>
                    <div class="md:ml-4">
                        @if ($userReward->status === 'pending')
                        <button type="button" class="approve-btn w-full md:w-auto bg-black text-white text-sm font-semibold px-4 py-2 rounded-lg" data-id="{{ $userReward->id }}">
                            Send Reward
                        </button>
                        @elseif ($userReward->status === 'claimed')
                        <button disabled class="w-full md:w-auto bg-green-600 text-white text-sm font-semibold px-4 py-2 rounded-lg opacity-70 cursor-not-allowed">
                            Claimed
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="flex justify-center lg:justify-end mt-4">
            <div class="bg-white rounded-[14px] shadow-sm px-5 py-3 flex items-center gap-4">
                <span class="text-base text-text-dark">
                    {{ $userRewards->firstItem() }}-{{ $userRewards->lastItem() }} of {{ $userRewards->total() }}
                </span>

                @if($userRewards->onFirstPage())
                <svg class="w-6 h-6 text-gray-300">
                    <path d="m15 18-6-6 6-6" /></svg>
                @else
                <a href="{{ $userRewards->previousPageUrl() }}">
                    <svg class="w-6 h-6 text-blue-500">
                        <path d="m15 18-6-6 6-6" /></svg>
                </a>
                @endif

                @if($userRewards->hasMorePages())
                <a href="{{ $userRewards->nextPageUrl() }}">
                    <svg class="w-6 h-6 text-blue-500">
                        <path d="m9 18 6-6-6-6" /></svg>
                </a>
                @else
                <svg class="w-6 h-6 text-gray-300">
                    <path d="m9 18 6-6-6-6" /></svg>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.approve-btn').forEach(button => {
            button.addEventListener('click', function() {
                let rewardId = this.dataset.id;
                let btn = this;

                btn.disabled = true;
                btn.textContent = 'Processing...';

                fetch(`/api/rewards/${rewardId}/approve`, {
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
                            btn.classList.add('bg-success', 'opacity-70', 'cursor-not-allowed');
                            btn.textContent = 'Claimed';
                        } else {
                            btn.disabled = false;
                            btn.textContent = 'Send Reward';
                            alert(data.message);
                        }
                    })
                    .catch(err => {
                        btn.disabled = false;
                        btn.textContent = 'Send Reward';
                        console.error(err);
                        alert('Something went wrong. Try again.');
                    });
            });
        });
    });

</script>

@endpush