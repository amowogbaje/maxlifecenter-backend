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
                <div class="w-9 h-9 rounded-full flex items-center justify-center {{ $card['bgColor'] }}">
                    {!! $card['svgIcon'] !!}
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
                <form method="GET" action="{{ route('admin.rewards')}}">
                    <div class="relative flex-1 lg:w-[412px]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-5 top-1/2 transform -translate-y-1/2 w-5 h-5 text-text-dark">
                            <circle cx="11" cy="11" r="8" />
                            <path d="m21 21-4.3-4.3" /></svg>
                        <input type="text" name="search" value="{{ request()->input('search') }}" placeholder="Search" class="w-full h-12 pl-14 pr-4 bg-white rounded-[14px] shadow-sm border-0 text-text-gray" />
                    </div>
                </form>

            </div>
        </div>

        <div class="space-y-3">
            @if($userRewards->count() > 0)
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
                                        <span class="text-sm text-text-light">Date Achieved</span>
                                        <span class="text-xs lg:text-base text-text-dark truncate" title="{{ $userReward->achieved_at }}">{{ \Carbon\Carbon::parse($userReward->achieved_at)->format('M d, Y H:i a') }}</span>
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
                                Issue Reward
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
            @else
            <div class="bg-white rounded-[24px] shadow-sm p-6 text-center">
                <svg class="mx-auto w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75h4.5m-2.25-2.25v4.5M12 3v1.5m0 15V21m9-9h-1.5M4.5 12H3m16.364 7.364l-1.061-1.061M6.697 6.697L5.636 5.636m12.728 0l-1.061 1.061M6.697 17.303l-1.061 1.061" />
                </svg>
                <p class="text-gray-500 text-sm lg:text-base">No rewards found.</p>
            </div>
            @endif
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
                            btn.textContent = 'Issue Reward';
                            alert(data.message);
                        }
                    })
                    .catch(err => {
                        btn.disabled = false;
                        btn.textContent = 'Issue Reward';
                        console.error(err);
                        alert('Something went wrong. Try again.');
                    });
            });
        });
    });

</script>

@endpush
